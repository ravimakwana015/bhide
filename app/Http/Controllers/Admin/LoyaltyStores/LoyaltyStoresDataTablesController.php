<?php

namespace App\Http\Controllers\Admin\LoyaltyStores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\Models\Services;
use App\Models\LoyaltyCard;

class LoyaltyStoresDataTablesController extends Controller
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
    	->editColumn('created_at', function ($loyalty_cards) {
    		return Carbon::parse($loyalty_cards->created_at)->format('d/m/Y H:i:s');
    	})
    	->editColumn('company_name', function ($loyalty_cards) {
    		return '<a href="' . route('companies.show', $loyalty_cards->company_id) . '" >' . $loyalty_cards->company_name . '</a> ';
    	})
        ->editColumn('lcategory_name', function ($loyalty_cards) {
            return $loyalty_cards->lcategory_name;
        })
    	->addColumn('actions', function ($loyalty_cards) { 
    		return '<button type="button" class="btn btn-outline-info" onclick="getData('.$loyalty_cards->loyalty_cards_id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit Loyalty Store"><i class="fas fa-user-edit"></i></button>   
    		<button type="button" class="btn btn-outline-danger" onclick="getDelete('.$loyalty_cards->loyalty_cards_id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete Loyalty Store"><i class="fas fa-trash"></i></button>';
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
    	$dataTableQuery = LoyaltyCard::leftJoin('companies', 'loyalty_cards.company_id', '=', 'companies.id')
        ->leftJoin('loyalty_categorys', 'loyalty_cards.category_id', '=', 'loyalty_categorys.id')
    	->select([
    		'companies.person_name',
    		'companies.company_name',
    		'companies.id as company_id',
    		'loyalty_cards.id as loyalty_cards_id',
    		'loyalty_cards.store_name',
    		'loyalty_cards.store_address',
    		'loyalty_cards.store_offers',
            'loyalty_categorys.id as category_id',
            'loyalty_categorys.lcategory_name',
    		'loyalty_cards.created_at',
    	]);

    	if (isset($input['company_name']) && $input['company_name'] != '') {
            $dataTableQuery->where('company_id',$input['company_name']);
        }
    	return $dataTableQuery;
    }
}
