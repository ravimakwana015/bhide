<?php

namespace App\Http\Controllers\LoyaltyCard;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\LoyaltyCard;
use App\Models\CompanySettings;
use App\Models\AppUsers;
use App\Models\LoyaltyCategorys;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Controller;

class LoyaltyCardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = LoyaltyCategorys::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Category';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->lcategory_name;
        }
        $companySettings = CompanySettings::where('company_id', Auth::user()->company->id)->first();
        return view('loyaltyCard.index', compact('companySettings','flats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('loyaltyCard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, NotificationController $notification)
    {
        $input = $request->except('_token', '_method');
        $this->validate($request, [
            'store_name' => 'required',
            'store_address' => 'required',
            'store_offers' => 'required',
        ]);
        $input['company_id'] = Auth::user()->company->id;
        LoyaltyCard::create($input);
        $deviceTokens = AppUsers::where('deviceToken', '!=', '')->pluck('deviceToken');
        if (count($deviceTokens) > 0) {
            try {
                $title = 'New Store Available';
                $body = 'New Store Available in Apartment';
                $type = 'Store';
                $res = $notification->senNotification($deviceTokens, $body, $title, $type);
                if ($res['status'] == 1) {
                    return response()->json(['status' => 1, 'msg' => 'Store Added Successfully!!']);
                } else {
                    return response()->json(['status' => 1, 'msg' => 'Store Added Successfully. Firebase Server Key No Available. Please Contact your Admin!!']);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return response()->json(['status' => 1, 'msg' => 'Store Added Successfully!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoyaltyCard  $loyaltyCard
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loyaltyCard = LoyaltyCard::find($id);
        return view('loyaltyCard.show', compact('loyaltyCard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoyaltyCard  $loyaltyCard
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $units = LoyaltyCategorys::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Category';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->lcategory_name;
        }
        $loyaltyCard = LoyaltyCard::find($id);
        $editService = view('loyaltyCard.edit_modal', compact('loyaltyCard','flats'))->render();
        return response()->json(['status' => 1, 'html' => $editService]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoyaltyCard  $loyaltyCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $loyaltyCard = LoyaltyCard::find($id);
        $input = $request->except('_token', '_method');
        $this->validate($request, [
            'store_name' => 'required',
            'store_address' => 'required',
            'store_offers' => 'required',
        ]);
        $loyaltyCard->update($input);
        return redirect()->route('loyaltyCard.index')->with('success', 'Store Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoyaltyCard  $loyaltyCard
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoyaltyCard::find($id)->delete();
        return redirect()->route('loyaltyCard.index')->with('success', 'Store Deleted Successfully!!');
    }

    public function getLoyaltyCard(Request $request)
    {
        return DataTables::make($this->getForDataTable($request->all()))
            ->editColumn('created_at', function ($loyaltyCard) {
                return Carbon::parse($loyaltyCard->created_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('updated_at', function ($loyaltyCard) {
                return Carbon::parse($loyaltyCard->updated_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('status', function ($loyaltyCard) {
                if ($loyaltyCard->status == 1) {
                    return '<label class="btn btn-warning btn-xs">Active</label>';
                } else  if ($loyaltyCard->status == 0) {
                    return '<label class="btn btn-success btn-xs">InActive</label>';
                }
            })
            ->addColumn('actions', function ($loyaltyCard) {
                $actions = '<a title="Edit Store" class="btn btn-sm btn-outline-primary btn-icon"  href="javascript:;" data-url="' . route('loyaltyCard.edit', $loyaltyCard->id) . '" id="edit_' . $loyaltyCard->id . '" onclick="editPopup(' . $loyaltyCard->id . ')" > <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
                </a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("loyaltyCard.destroy", $loyaltyCard) . '" id="delete_' . $loyaltyCard->id . '" onclick="deletePopup(' . $loyaltyCard->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
                return $actions;
            })
            ->rawColumns(['actions', 'loyalty_card_image', 'status'])
            ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = LoyaltyCard::where('company_id',Auth::user()->company->id)->orderBy('id', 'desc');
        // if (isset($input['month']) && $input['month'] != '') {
        //     $dataTableQuery->whereMonth('created_at', '=', $input['month']);
        // }
        // if (isset($input['year']) && $input['year'] != '') {
        //     $dataTableQuery->whereYear('created_at', '=', $input['year']);
        // }
        // if (isset($input['from_date']) && isset($input['to_date']) && $input['from_date'] != '' && $input['to_date'] != '') {
        //     $dataTableQuery->whereBetween('created_at', array($input['from_date'], $input['to_date']));
        // }
        // if (isset($input['status']) && $input['status'] != '') {

        //     $dataTableQuery->where(function ($fq) use ($input) {
        //         if ($input['status'] == '7') {
        //             $fq->where('status', '=', '3')->orWhere('status', '=', '7');
        //         } else {
        //             $fq->where('status', '=', $input['status']);
        //         }
        //     });
        // }
        // if (isset($input['payment_status']) && $input['payment_status'] != '') {
        //     $dataTableQuery->where('payment_status', '=', $input['payment_status']);
        // }
        return  $dataTableQuery;
    }
}
