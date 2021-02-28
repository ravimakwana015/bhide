<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\AboutApartments;
use App\Models\Bills;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailDatas;
use App\Mail\RealEstateMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;

class AboutApartmentController extends Controller
{

	public function getapartments(Request $request){

		$validator = Validator::make($request->all(), [
			'company_id' => 'required',
			// 'user_id' => 'required',
			'unit_id' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()], 422);
		}
		else
		{
			$aboutApartments = AboutApartments::where('company_id',$request->company_id)->where('unit_id',$request->unit_id)->orderBy('id', 'desc')->first();
			if (isset($aboutApartments)) {
				return response()->json(['data' => $aboutApartments], 200);
			} else {
				return response()->json(['error' => 'Not Found'], 422);
			}
		}
	}

	public function aboutApartmentUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'floor_plan' => 'required',
            'type_of_paint' => 'required',
            'lightbulbs' => 'required',
            'window_sizes' => 'required',
            'oven' => 'required',
            'fridge' => 'required',
            'dishwasher' => 'required',
            'washing_machine' => 'required',
            'boiler_information' => 'required',
            'air_conditioning' => 'required',
            'heating' => 'required',
            'hob' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $aboutApartmentsData = AboutApartments::where('company_id',$request->company_id)->where('unit_id',$request->unit_id)->first();
        
        if(isset($aboutApartmentsData)) 
        {
            $aboutApartmentsData->update([
                'floor_plan' => $request->floor_plan,
                'type_of_paint' => $request->type_of_paint,
                'lightbulbs' => $request->lightbulbs,
                'window_sizes' => $request->window_sizes,
                'oven' => $request->oven,
                'fridge' => $request->fridge,
                'dishwasher' => $request->dishwasher,
                'washing_machine' => $request->washing_machine,
                'boiler_information' => $request->boiler_information,
                'air_conditioning' => $request->air_conditioning,
                'heating' => $request->heating,
                'hob' => $request->hob,
            ]);
            return response()->json(['msg' => "Apartmets Details Updated", 'success' => true], 200);
        } else 
        {
            AboutApartments::create([
                'company_id' => $request->company_id,
                'unit_id' => $request->unit_id,
                'floor_plan' => $request->floor_plan,
                'type_of_paint' => $request->type_of_paint,
                'lightbulbs' => $request->lightbulbs,
                'window_sizes' => $request->window_sizes,
                'oven' => $request->oven,
                'fridge' => $request->fridge,
                'dishwasher' => $request->dishwasher,
                'washing_machine' => $request->washing_machine,
                'boiler_information' => $request->boiler_information,
                'air_conditioning' => $request->air_conditioning,
                'heating' => $request->heating,
                'hob' => $request->hob,
            ]);
            return response()->json(['msg' => "Apartmets Details Updated", 'success' => true], 200);
            // return response()->json(['msg' => 'Not Found', 'data' => null, 'success' => false], 422);
        }
    }

    public function billApartmentUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'home_insurance' => 'required',
            'electricity_provider' => 'required',
            'gas_provider' => 'required',
            'water' => 'required',
            'telephone' => 'required',
            'broadband' => 'required',
            'mobile' => 'required',
            'council_tax' => 'required',
            'tv_license' => 'required',
            'car_expenses' => 'required',
            'service_charge' => 'required',
            'ground_rent' => 'required',
            'parking_fees' => 'required',
            'gym' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $aboutApartmentsData = AboutApartments::where('company_id',$request->company_id)->where('unit_id',$request->unit_id)->first();
        
        if(isset($aboutApartmentsData)) {
            $aboutApartmentsData->update([
                'home_insurance' => $request->home_insurance,
                'electricity_provider' => $request->electricity_provider,
                'gas_provider' => $request->gas_provider,
                'water' => $request->water,
                'telephone' => $request->telephone,
                'broadband' => $request->broadband,
                'mobile' => $request->mobile,
                'council_tax' => $request->council_tax,
                'tv_license' => $request->tv_license,
                'car_expenses' => $request->car_expenses,
                'service_charge' => $request->service_charge,
                'ground_rent' => $request->ground_rent,
                'parking_fees' => $request->parking_fees,
                'gym' => $request->gym,
            ]);
            return response()->json(['msg' => "Bill Details Updated", 'success' => true], 200);
        } else {
            AboutApartments::create([
                'home_insurance' => $request->home_insurance,
                'electricity_provider' => $request->electricity_provider,
                'gas_provider' => $request->gas_provider,
                'water' => $request->water,
                'telephone' => $request->telephone,
                'broadband' => $request->broadband,
                'mobile' => $request->mobile,
                'council_tax' => $request->council_tax,
                'tv_license' => $request->tv_license,
                'car_expenses' => $request->car_expenses,
                'service_charge' => $request->service_charge,
                'ground_rent' => $request->ground_rent,
                'parking_fees' => $request->parking_fees,
                'gym' => $request->gym,
            ]);
            return response()->json(['msg' => "Bill Details Updated", 'success' => true], 200);
            // return response()->json(['msg' => 'Not Found', 'data' => null, 'success' => false], 422);
        }
    }

    public function addBill(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bill_category' => 'required',
            'title' => 'required',
            'payment_date' => 'required',
            'bill_amount' => 'required',
            'user_id' => 'required',
            'company_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        Bills::create([
            'bill_category' => $request->bill_category,
            'title' => $request->title,
            'payment_date' => $request->payment_date,
            'bill_amount' => $request->bill_amount,
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
        ]);
        return response()->json(['msg' => "Bill Add Successfull", 'success' => true], 200);
            // return response()->json(['msg' => 'Not Found', 'data' => null, 'success' => false], 422);
        
    }

    public function getBill(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) 
        {
            return response()->json(['error' => $validator->errors()], 422);
        }
        else
        {

            $getbillApartments = Bills::where('company_id',$request->company_id)->where('user_id',$request->user_id)->orderBy('created_at', 'DESC')->get();

            $group = array();

            foreach ( $getbillApartments as $value ) {
                $dateFormat = Carbon::parse($value['payment_date'])->format('Y-m');
                $group[$dateFormat]['formatdate'] = Carbon::parse($value['payment_date'])->format('F Y');
                $group[$dateFormat]['items'][] = $value;
            }
            if(isset($group)) {
                asort($group);
                return response()->json(['data' => $group], 200);
            } else {
                return response()->json(['msg' => 'Not Found', 'data' => null, 'success' => false], 422);
            }
        }
    }


    public function addEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        $user = EmailDatas::create([
            'company_id' => $request->company_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);
        Mail::to($request->sendemail)->send(new RealEstateMail($user));
        return response()->json(['msg' => "Add Successfull", 'success' => true], 200);
    }

    public function getRecords(Request $request){

        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        else
        {
            $data['sumCount'] = Bills::whereMonth('payment_date', date('m'))
            ->whereYear('payment_date', date('Y'))
            ->where('company_id',$request->company_id)->where('user_id',$request->user_id)
            ->sum('bill_amount');

            $data['yearCount'] = Bills::whereYear('payment_date', date('Y'))
            ->where('company_id',$request->company_id)->where('user_id',$request->user_id)
            ->sum('bill_amount');
            
            if (isset($data)) {
                return response()->json(['data' => $data], 200);
            } else {
                return response()->json(['error' => 'Not Found'], 422);
            }
        }
    }

}
?>
