<?php

namespace App\Http\Controllers\Admin\Company;

use Stripe;
use App\Http\Controllers\Controller;

class StripePlanController extends Controller
{
    public function createSubscriptionPlan($company)
    {
        Stripe\Stripe::setApiKey(config('cashier.secret'));
        $interval_count = 1;
        $interval = $company->subscription_time;
        if ($interval == 'quarter') {
            $interval_count = 3;
            $interval = 'month';
        }

        try {
            $plan = \Stripe\Plan::create([
                "amount" => $company->subscription_amount * 100.00,
                "trial_period_days" => 0,
                "interval" => $interval,
                "interval_count" => $interval_count,
                "product" => [
                    "name" => $company->company_name
                ],
                "currency" => "gbp",
                "id" => mt_rand(1000000000, 9999999999)
            ]);
            return [
                'status' => true,
                'plan' => $plan
            ];
        } catch (\Stripe\Exception\RateLimitException $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
