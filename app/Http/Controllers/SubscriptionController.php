<?php

namespace App\Http\Controllers;

use Stripe;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$subscriptions = DB::table('subscriptions')->where('user_id', Auth::user()->id)->get();
    	if (count($subscriptions) > 1) 
        {
            foreach ($subscriptions as $subscription) {
                if ($subscription->trial_ends_at != '') {
                    DB::table('subscriptions')->where('id', $subscription->id)->delete();
                }
            }
            if (Auth::user()->owner->trial_ends_at != '' && Auth::user()->owner->stripe_id == Auth::user()->username && Auth::user()->planid != '') {
                Auth::user()->update(['status' => 0]);
                DB::table('subscriptions')->where('user_id', Auth::user()->id)->update(['stripe_status' => 'trialing']);
            }
        }
        Stripe\Stripe::setApiKey(config('cashier.secret'));
        if (Auth::user()->subscription('main')) {
            $plan = Stripe\Plan::retrieve(Auth::user()->subscription('main')->stripe_plan);
            $subscription = \Stripe\Subscription::retrieve(Auth::user()->subscription('main')->stripe_id);
            $cards = [];
            $defaultPaymentMethod = '';
            if (Auth::user()->hasPaymentMethod()) {
                foreach (Auth::user()->paymentMethods() as $key => $value) {
                    $cards[] = $value->asStripePaymentMethod();
                }
                $defaultPaymentMethod = Auth::user()->defaultPaymentMethod()->asStripePaymentMethod()->id;
            }

            return view('subscription.index', compact('plan','subscription', 'cards', 'defaultPaymentMethod'));
        }
        else
        {
            return view('subscription.index');
        }
    }
    /**
     * @return Factory|View
     * @throws Stripe\Exception\ApiErrorException
     */
    public function getMembershipPlan()
    {
        Stripe\Stripe::setApiKey(config('cashier.secret'));
        $plans = Stripe\Plan::all();
        return view('subscription.change-membership-plan', compact('plans'));
    }

    /**
     * @param $plan_id
     * @return RedirectResponse
     */
    public function changeMembershipPlan($plan_id)
    {
        $user = Auth::user();
        $user -> subscription('main') -> swap($plan_id);
        return redirect() -> route('subscription') -> with('success', 'Membership Updated Successfully.');
    }
}
