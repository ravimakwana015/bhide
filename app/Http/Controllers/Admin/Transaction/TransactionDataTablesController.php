<?php

namespace App\Http\Controllers\Admin\Transaction;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Http\Controllers\Controller;

class TransactionDataTablesController extends Controller
{
    /**
     * Process ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getData(Request $request)
    {
        return Datatables::make($this->getForDataTable($request->all()))
        ->escapeColumns(['id'])
        ->editColumn('created_at', function ($transaction) {
            return Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s');
        })
        ->editColumn('company_name', function ($transaction) {
            return '<a href="' . route('companies.show', $transaction->company_id) . '" >' . $transaction->company_name . '</a> ';
        })
        ->editColumn('amount', function ($transaction) {
            return '£' . number_format($transaction->amount, 2);
        })
        ->addColumn('transaction_id', function ($transaction) {
            if (isset($transaction->user)) {
                return $transaction->user->defaultPaymentMethod()->id;
            } else {
                return "N/A";
            }
        })
        ->editColumn('payment_status', function ($transaction) {
            if ($transaction->payment_status == 0) {
                return '<label class="btn btn-warning btn-xs">Pending</label>';
            } else  if ($transaction->payment_status == 1) {
                return '<label class="btn btn-success btn-xs">Paid</label>';
            }
        })
        ->make(true);
    }

    /**
     * getForDataTable
     *
     * @return void
     */
    public function getForDataTable($input)
    {
        $dataTableQuery = Transaction::leftJoin('companies', 'transactions.user_id', '=', 'companies.user_id')
        ->select([
            'companies.person_name',
            'companies.company_name',
            'companies.id as company_id',
            'transactions.created_at',
            'transactions.payment_status',
            'transactions.amount',
            'transactions.user_id as user_id',
        ]);

        if (isset($input['company_name']) && $input['company_name'] != '') {
            
            $dataTableQuery->where('company_id',$input['company_name']);
        }
        return $dataTableQuery;
    }
}
