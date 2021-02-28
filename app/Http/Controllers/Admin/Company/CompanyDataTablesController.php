<?php

namespace App\Http\Controllers\Admin\Company;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Settings;
use App\Models\Company;
use App\Http\Controllers\Controller;

class CompanyDataTablesController extends Controller
{
    /**
     * Process ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getData(Request $request)
    {
        if (isset($request->company_name) && $request->company_name != '') {

            return Datatables::make(Company::query()->where('id',$request->company_name))
            ->escapeColumns(['id'])
            ->editColumn('created_at', function ($company) {
                return Carbon::parse($company->created_at)->format('d/m/Y H:i:s');
            })
            ->editColumn('payment_url', function ($company) {
                if ($company->payment_status == 0) {
                    return route('payment.details', [$company->unique_id]);
                } else {
                    return "N/A";
                }
            })
            ->editColumn('subscription_amount', function ($company) {
                $settings = Settings::first();
                return $settings->currency_symbol . number_format($company->subscription_amount,2);
            })
            ->editColumn('payment_status', function ($company) {
                if ($company->payment_status == 0) {
                    return '<label class="btn btn-warning btn-xs">Pending</label>';
                } else  if ($company->payment_status == 1) {
                    return '<label class="btn btn-success btn-xs">Paid</label>';
                }
            })
            ->addColumn('actions', function ($company) {
                if ($company->payment_status == 0) {
                    return '<a href="' . route('companies.show', $company->id) . '" class="btn btn-secondary">View</a> <a href="' . route('companies.edit', $company->id) . '" class="btn btn-info">Edit</a> <a href="' . route('send.payment.link', $company->id) . '" class="btn btn-primary">Send Payment Link</a> <button type="button" class="btn btn-danger addAttr" data-url="' . route("companies.destroy", $company) . '" id="delete_' . $company->id . '" onclick="deletePopup(' . $company->id . ')">Delete </button>';
                } else {
                    return '<a href="' . route('companies.show', $company->id) . '" class="btn btn-secondary">View</a> <a href="' . route('companies.edit', $company->id) . '" class="btn btn-primary">Edit</a> <a href="' . route('send.login.details', $company->id) . '" class="btn btn-info">Send Login Details</a>';
                }
            })
            ->make(true);
        }
        else
        {
            return Datatables::make(Company::query())
            ->escapeColumns(['id'])
            ->editColumn('created_at', function ($company) {
                return Carbon::parse($company->created_at)->format('d/m/Y H:i:s');
            })
            ->editColumn('payment_url', function ($company) {
                if ($company->payment_status == 0) {
                    return route('payment.details', [$company->unique_id]);
                } else {
                    return "N/A";
                }
            })
            ->editColumn('subscription_amount', function ($company) {
                $settings = Settings::first();
                return $settings->currency_symbol . number_format($company->subscription_amount,2);
            })
            ->editColumn('payment_status', function ($company) {
                if ($company->payment_status == 0) {
                    return '<label class="btn btn-warning btn-xs">Pending</label>';
                } else  if ($company->payment_status == 1) {
                    return '<label class="btn btn-success btn-xs">Paid</label>';
                }
            })
            ->addColumn('actions', function ($company) {
                if ($company->payment_status == 0) {
                    return '<a href="' . route('companies.show', $company->id) . '" class="btn btn-secondary">View</a> <a href="' . route('companies.edit', $company->id) . '" class="btn btn-info">Edit</a> <a href="' . route('send.payment.link', $company->id) . '" class="btn btn-primary">Send Payment Link</a> <button type="button" class="btn btn-danger addAttr" data-url="' . route("companies.destroy", $company) . '" id="delete_' . $company->id . '" onclick="deletePopup(' . $company->id . ')">Delete </button>';
                } else {
                    return '<a href="' . route('companies.show', $company->id) . '" class="btn btn-secondary">View</a> <a href="' . route('companies.edit', $company->id) . '" class="btn btn-primary">Edit</a> <a href="' . route('send.login.details', $company->id) . '" class="btn btn-info">Send Login Details</a>';
                }
            })
            ->make(true);
        }
    }
}
