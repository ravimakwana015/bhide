<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Units;
use App\Models\Concierges;
use App\Models\Parcels;
use App\Models\Polls;
use App\Models\Transaction;
use App\Models\Visitors;
use App\Models\Services;
use App\Models\LoyaltyCard;
use App\Admin;
use App\Models\AppUsers;
use App\Models\UnitIssueRequest;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $master=[];
        $master['totalCompanies'] = Company::count();
        $master['totalCompanies'] = Company::count();
        $master['totalUnits'] = Units::count();
        $master['totalConcierges'] = Concierges::count();
        $master['totalParcels'] = Parcels::count();
        $master['totalPolls'] = Polls::count();
        $master['totalTransaction'] = Transaction::count();
        $master['totalVisitors'] = Visitors::count();
        $master['totalServices'] = Services::count();
        $master['totalLoyaltyCard'] = LoyaltyCard::count();
        $master['totalUnitIssueRequest'] = UnitIssueRequest::count();
        $master['totalamount'] = Transaction::sum('amount');

        $master['latestCompanies'] = Company::orderBy('id', 'desc')->take(10)->get();
        $master['latestTransactions'] = Transaction::leftJoin('companies', 'transactions.user_id', '=', 'companies.user_id')
        ->select([
            'companies.person_name',
            'companies.company_name',
            'companies.id as company_id',
            'transactions.created_at',
            'transactions.payment_status',
            'transactions.amount',
            'transactions.user_id as user_id',
        ])->orderBy('transactions.id', 'desc')->take(10)->get();
        $master['latestPolls'] = Polls::leftJoin('companies', 'polls.company_id', '=', 'companies.id')->orderBy('polls.id', 'desc')->take(10)->get();
        $master['latestissues'] = UnitIssueRequest::leftJoin('companies', 'unit_issue_requests.company_id', '=', 'companies.id')
        ->leftJoin('units', 'unit_issue_requests.unit_id', '=', 'units.id')
        ->leftJoin('app_users', 'unit_issue_requests.user_id', '=', 'app_users.id')
        ->select([
            'companies.person_name',
            'companies.company_name',
            'companies.id as company_id',
            'app_users.first_name as first_name',
            'app_users.middle_name as middle_name',
            'app_users.last_name as last_name',
            'units.block_number as block_number',
            'units.flat_number as flat_number',
            'unit_issue_requests.id as unit_issue_requests_id',
            'unit_issue_requests.issue',
            'unit_issue_requests.status as unit_issue_requests_status',
            'unit_issue_requests.created_at',
        ])->orderBy('unit_issue_requests.id', 'desc')->take(10)->get();


        $master['latestnewappusers'] = AppUsers::leftjoin('companies as c', 'c.id', '=', 'app_users.company_id')
        ->leftjoin('units as u', 'app_users.unit_id', '=', 'u.id')
        ->select([
            'app_users.*',
            DB::raw('CONCAT(app_users.last_name," ",app_users.first_name) AS name'),
            DB::raw('CONCAT(u.block_number,"-",u.flat_number) AS unit_name'),
            'c.id as cid',
            'c.company_name',
        ])
        ->orderBy('id', 'desc')->take(8)->get();

        $master['latestcoinusers'] = Concierges::leftjoin('gates as g', 'g.id', '=', 'concierges.gate_id')
        ->select([
            'concierges.*',
            DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
            'g.id as cid',
            'g.name as gate_name',
        ])->orderBy('id', 'desc')->take(8)->get();
        

        return view('admin.dashboard',compact('master'));
    }

    public function adminDetails($value='')
    {
        $adminDetails = Admin::first();
        return view('admin.details.index',compact('adminDetails'));
    }

    public function adminUpdateDetails(Request $request)
    {
        $adminDetails = Admin::first();
        Admin::where('id',$request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        Session::flash('success', "Admin Details Update Successfully !!");
        return redirect()->route('admin.details');
    }

    public function adminUserChangePassword(Request $request)
    {
        $adminDetails = Admin::first();
        Admin::where('id',$request->id)->update([
            'password' => bcrypt($request->new_password),
        ]);

        Session::flash('success', "Admin Password Update Successfully !!");
        return redirect()->route('admin.details');
    }

    public function chart()
    {

        $monthwisecount = DB::select('SELECT  YEAR(created_at) AS y, MONTH(created_at) AS m, COUNT(DISTINCT id) as count FROM app_users GROUP BY y,m');

        if (isset($monthwisecount)) {
            $year = array();
            foreach ($monthwisecount as $key => $value) {
                $year[$value -> y][$value -> m] = $value -> count;
            }
            for ($i = 1; $i <= 12; $i++) {
                foreach ($year as $key => $value) {
                    if (isset($value[$i])) {
                        $year[$key][$i] = $value[$i];
                    } else {
                        $year[$key][$i] = 0;
                    }
                    ksort($year);
                }
            }

            foreach ($year as $x => $x_value) {
                ksort($x_value);
                $year[$x] = $x_value;
            }

            return array(
                'data' => $year
            );
        }
    }

}
