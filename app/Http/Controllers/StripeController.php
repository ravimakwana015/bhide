<?php

namespace App\Http\Controllers;

use Stripe;
use Psy\Exception\Exception;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Support\Renderable;
use App\OpeningHours;
use App\Mail\SubscriptionMail;
use App\EmployeeInfo;
use App\EmergencyHours;

class StripeController extends Controller
{
    protected $stripe;
    public function __construct()
    {
        Stripe\Stripe::setApiKey(config('cashier.secret'));
        $this->stripe = new \Stripe\StripeClient(config('cashier.secret'));
    }

    /**
     * Show All Plans.
     *
     * @return Renderable
     * @throws Stripe\Exception\ApiErrorException
     */
    public function plans()
    {
        if (Auth::user()->subscribed('main')) {
            return redirect()->route('home');
        } else {

            $plans = Stripe\Plan::all();
            return view('packages', compact('plans'));
        }
    }


    /**
     * Get Plans.
     *
     * @param $planId
     * @return Factory|RedirectResponse|View
     */
    public function payment($planId)
    {

        if (Auth::user()->subscribed('main')) {
            return redirect()->route('home');
        } else {
            try {

                $plan = Stripe\Plan::retrieve($planId);
                return view('plan', compact('plan'));
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
    }



    /**
     * Cancle subscription
     * @param Request $request
     * @return RedirectResponse
     */
    public function cancleMembership(Request $request)
    {
        $input = $request->all();
        // if (isset($input['feedback']) && $input['feedback'] != '') {
        //     DB::table('cancel_membership_feedback')->insert([
        //         'user_id' => Auth::user()->id,
        //         'feedback' => $input['feedback'],
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ]);
        // }
        Auth::user()->subscription('main')->cancel();
        // Mail::to(Auth::user()->email)->send(new SubscriptionCancleMail(Auth::user(), 'user'));
        // $setting = settings();
        // Mail::to($setting[0]->email)->send(new SubscriptionCancleMail(Auth::user(), 'admin'));

        return back()->with('success', 'Membership has been Cancelled Successfully');
    }

    /**
     * Resume subscription
     *
     */
    public function resumeMembership()
    {
        if (Auth::user()->hasPaymentMethod()) {
            Auth::user()->subscription('main')->resume();
            return back()->with('success', 'Membership has been Resumed Successfully');
        } else {
            return back()->with('error', 'Please Add a Payment Method');
        }
    }

    /**
     * Add User Stripe Card.
     * @param Request $request
     * @return false|string
     */
    public function addCard(Request $request)
    {
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
            Auth::user()->addPaymentMethod($paymentMethod);
            if (!Auth::user()->hasPaymentMethod()) {
                Auth::user()->updateDefaultPaymentMethod($paymentMethod);
            }
            return back()->with('success', 'Card Added Successfully');
        } catch (\Stripe\Exception\RateLimitException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return back()->with('error', $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * get User Stripe Card.
     * @param Request $request
     * @return false|string
     */
    public function getCard(Request $request)
    {
        $input = $request->all();


        try {
            $paymentMethod = \Stripe\PaymentMethod::retrieve(
                $input['cardid']
            );
            return json_encode(array('status' => 1, 'card' => $paymentMethod));
        } catch (\Stripe\Exception\RateLimitException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return back()->with('error', $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update User Stripe Card.
     * @param Request $request
     * @return false|string
     */
    public function updateCard(Request $request)
    {
        $input = $request->all();


        try {
            $paymentMethodUpdate = Stripe\PaymentMethod::update(
                $input['cardid'],
                [
                    'card' =>
                    [
                        'exp_month' => $input['exp_month'],
                        'exp_year' => $input['exp_year'],
                    ]
                ]
            );
            return back()->with('success', 'Card Updated Successfully');
        } catch (\Stripe\Exception\RateLimitException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return back()->with('error', $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete User Stripe Card.
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteCard(Request $request)
    {
        $input = $request->all();

        try {
            $paymentMethod = \Stripe\PaymentMethod::retrieve(
                $input['cardid']
            );
            Auth::user()->removePaymentMethod($paymentMethod);
            return back()->with('success', 'Card Deleted Successfully.');
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

    /**
     * Set Default Stripe Card.
     * @param Request $request
     * @return false|string
     */
    public function setDefaultCard(Request $request)
    {
        $input = $request->all();

        try {
            $paymentMethod = \Stripe\PaymentMethod::retrieve(
                $input['cardid']
            );
            Auth::user()->updateDefaultPaymentMethod($paymentMethod);
            return json_encode(array('status' => 1, 'msg' => 'Card Set as Default Successfully'));
        } catch (\Stripe\Exception\RateLimitException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return back()->with('error', $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
