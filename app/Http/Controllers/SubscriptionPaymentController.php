<?php

namespace App\Http\Controllers;

use Stripe;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\SubscriptionFailedNotification;
use App\Notifications\NewSubscriptionNotification;
use App\Notifications\AdminSubscriptionFailedNotification;
use App\Models\Transaction;
use App\Models\Company;
use App\Mail\SubscriptionMail;
use App\Admin;

class SubscriptionPaymentController extends Controller
{
    /**
     * Payment form for subscription
     *
     * @param string $id
     * @return void
     */
    public function paymentDetails(string $id)
    {
        Stripe\Stripe::setApiKey(config('cashier.secret'));
        $company = Company::where('unique_id', $id)->first();
        if (isset($company)) {
            if ($company->payment_status == 0) {
                return view('subscription.plan_details', compact('id', 'company'));
            } else {
                return redirect('/')->with('error', 'Already Purchase this subscription');
            }
        } else {
            return redirect('/')->with('error', 'No Detail fround');
        }
    }
    /**
     * Payment form for subscription
     *
     * @param string $id
     * @return void
     */
    public function payment(string $id)
    {
        Stripe\Stripe::setApiKey(config('cashier.secret'));
        $company = Company::where('unique_id', $id)->first();

        if (isset($company)) {
            if ($company->payment_status == 0) {
                try {
                    $plan = \Stripe\Plan::retrieve($company->plan_id);
                    return view('subscription.plan', compact('plan', 'company'));
                } catch (\Stripe\Exception\RateLimitException $e) {
                    return redirect('/')->with('error', $e->getMessage());
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    return redirect('/')->with('error', $e->getMessage());
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    return redirect('/')->with('error', $e->getMessage());
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    return redirect('/')->with('error', $e->getMessage());
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    return redirect('/')->with('error', $e->getMessage());
                } catch (Exception $e) {
                    return redirect('/')->with('error', $e->getMessage());
                }
            } else {
                return redirect('/')->with('error', 'Already Purchase this subscription');
            }
        } else {
            return redirect('/')->with('error', 'No Detail found');
        }
    }

    /**
     * subscribed User to  Plans.
     * @param Request $request
     * @return RedirectResponse
     */
    public function orderPost(Request $request)
    {
        Stripe\Stripe::setApiKey(config('cashier.secret'));
        $company = Company::where('id',  $request->company_id)->first();
        $input = $request->all();
        try {
            $paymentMethod = \Stripe\PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'number' => $input['number'],
                    'exp_month' => $input['exp_month'],
                    'exp_year' => $input['exp_year'],
                    'cvc' => $input['cvc']
                ]
            ]);
            try {
                $user = User::where('id', $company->user_id)->first();
                $user->newSubscription('main', $input['plan'])->create($paymentMethod);
                $company->update([
                    'payment_status' => 1
                ]);
                Transaction::create([
                    'user_id' => $user->id,
                    'payment_status' => 1,
                    'amount' => $company->subscription_amount,
                ]);

                $invoice = $user->invoices()[0];
                $invoice_details = [];
                $invoice_details['amount'] = $invoice->lines->data[0]->amount;
                $invoice_details['start'] = $invoice->lines->data[0]->period->start;
                $invoice_details['end'] = $invoice->lines->data[0]->period->end;
                $invoice_details['description'] = $invoice->lines->data[0]->description;
                $invoice_details['number'] = $invoice->number;
                $invoice_details['payment_date'] = $invoice->status_transitions->paid_at;
                $invoice_details['user'] = [
                    'company_name' => $company->company_name,
                    'name' => $company->person_name,
                    'email' => $company->email,
                    'company_address' => $company->company_address,
                    'mobile' => $company->mobile,
                    'landline' => $company->landline,
                    'apartment_count' => $company->apartment_count,
                ];
                $pdf = PDF::loadView('subscription.invoice', array('invoice_details'=>$invoice_details));
                $filename = "invoice_".$invoice->number.".pdf";
                Storage::put('pdf/'.$filename, $pdf->output());
                Mail::to($user->email)->send(new SubscriptionMail($user,$filename));
                $admin=Admin::where('email','admin@admin.com')->first();
                $admin->notify(new NewSubscriptionNotification($user));
                return redirect()->route('thank.you')->with('success', 'Subscription has been completed. We look forward to having you on our platform!');
            } catch (\Stripe\Exception\RateLimitException $e) {
                $this->subscriptionFailedNotification($user,$e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                $this->subscriptionFailedNotification($user,$e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());
            } catch (\Stripe\Exception\AuthenticationException $e) {
                $this->subscriptionFailedNotification($user,$e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                $this->subscriptionFailedNotification($user,$e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $this->subscriptionFailedNotification($user,$e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());
            } catch (Exception $e) {
                $this->subscriptionFailedNotification($user,$e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());
            }
        } catch (\Stripe\Exception\RateLimitException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function thankYou(){
        return view('subscription.thank_you');
    }
    public function subscriptionFailedNotification($user,$message){
        $admin=Admin::where('email','admin@admin.com')->first();
        $admin->notify(new AdminSubscriptionFailedNotification($message,$user));
        $user->notify(new SubscriptionFailedNotification($message,$user));
    }
}
