<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings;
use App\Models\Pages;
use App\Models\Concierges;
use DB;
use App\Admin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $settings = Settings::first();
        $pagesforfront = Pages::all();
        $adminalldetails = Admin::all();
        if(isset(Auth::user()->company->id))
        {   
            $conciergesDetail = Concierges::where('concierges.company_id', Auth::user()->company->id)
            ->whereTime('shift_start', '>=', date('H:i'))
            ->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
            ->leftjoin('gates as g', 'g.id', '=', 'concierges.gate_id')
            ->select([
                'concierges.*',
                DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
                'g.id as cid',
                'g.name as gate_name',
            ])
            ->orderBy('id', 'desc')
            ->get();
            
            View::share('conciergesDetail', $conciergesDetail);
        }

        View::share('settings', $settings);
        View::share('pagesforfront', $pagesforfront);
        View::share('adminalldetails', $adminalldetails);
    }
}
