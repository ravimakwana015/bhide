<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\RealEstate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\AppUsers;
use App\Http\Controllers\NotificationController;
use DB;
use URL;
use App\Http\Controllers\API\ResponseController as ResponseController;

class RealEstateController extends ResponseController
{
    /**
     * Associated Repository Model.
     */
    protected $upload_path;
    protected $storage;

    /**
     *
     */

    /**
     *
     */
    public function __construct(AppUsers $model)
    {
        $this->model = $model;

        $this->upload_path = DIRECTORY_SEPARATOR.'realEstate'.DIRECTORY_SEPARATOR;

        $this->storage = Storage::disk('public');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $realestates = RealEstate::leftjoin('companies', 'real_estates.company_id', '=', 'companies.id')
        // ->leftjoin('agents', 'real_estates.agent_id', '=', 'agents.id')
        // ->select([
        //     'real_estates.*',
        //     'agents.id as aid',
        //     'agents.company_id as acompany_id',
        //     'agents.agent_name',
        //     'agents.agent_email',
        //     'agents.agent_phone_no',
        //     'companies.company_name'
        // ])
        // ->orderBy('real_estates.id', 'desc')->paginate(10);

        // if (!empty($realestates)) 
        // {
        //     foreach ($realestates as $key => $singleFeeds) 
        //     {
        //         $datatat = json_decode($realestates[$key]->images);
        //         $property_array = [];
        //         if (!empty($datatat->image)) 
        //         {
        //             foreach ($datatat->image as $image_key => $image_value) {
        //                 $property_array[] = url('public/realEstate/').'/'.$image_value;
        //             }   
        //         }

        //         $realestates[$key]->images = $property_array;
        //     }
        // }

        // if (isset($realestates)) {
        //     return response()->json(['data' => $realestates], 200);
        // } else {
        //     return response()->json(['error' => 'No record Found'], 422);
        // }

        $realestates = RealEstate::leftjoin('companies', 'real_estates.company_id', '=', 'companies.id')
        ->leftjoin('agents', 'real_estates.agent_id', '=', 'agents.id')
        ->where('real_estates.property_type','For Sale')
        ->select([
            'real_estates.*',
            'agents.id as aid',
            'agents.company_id as acompany_id',
            'agents.agent_name',
            'agents.agent_email',
            'agents.agent_phone_no',
            'companies.id as company_id',
            'companies.company_name'
        ])
        ->orderBy('real_estates.id', 'desc')->get();
        
        if (!empty($realestates)) 
        {
            foreach ($realestates as $key => $singleFeeds) 
            {
                $datatat = json_decode($realestates[$key]->images);
                $property_array = [];
                if (!empty($datatat->image)) 
                {
                    foreach ($datatat->image as $image_key => $image_value) {

                        if(!empty($image_value))
                        {
                            $property_array[] = url('public/realEstate/').'/'.$image_value;
                        }
                        else
                        {

                        }

                    }   
                }

                $realestates[$key]->images = $property_array;
            }
        }

        $group = array();
        $companyId = "";
        foreach ( $realestates as $value ) {
            if (empty($companyId ) || $companyId != $value['company_id']) {
             $companyId = $value['company_id'];     
             $group[$companyId]['buildingName'] = $value['company_name'];
             $group[$companyId]['items'][] = $value;
         } else {
          $group[$companyId]['items'][] = $value;
      } 
  }


  $perPage = 10;
  $options = [];
  $page = null;
  $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
  $items = $group instanceof Collection ? $group : Collection::make($group);

  if (isset($group)) {
    return response()->json(new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options), 200);
} else {
    return response()->json(['error' => 'No record Found'], 422);
}
}



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,NotificationController $notification)
    {
        $input=$request->all();
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'company_id' => 'required',
            'user_id' => 'required',
            'price' => 'required',
            'beds' => 'required',
            'baths' => 'required',
            'furnished' => 'required',
            'lease_length' => 'required',
            'availability' => 'required',
            'enquiry_by' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'facilities' => 'required',
            'description' => 'required',
            'status' => 'required',
            'property_type' => 'required',
        ]);

        if (isset($input['images']) && !empty($input['images']))
        {   
            $rules = array(
                'images[]' => 'image|mimes:jpeg,png,jpg'
            );
            $messages = [
                'images[].mimes' => 'Only jpeg,png and jpg images are allowed',
                'images[].max' => 'Sorry! Maximum allowed size for an image is 2MB'
            ];
            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails())
            {
                return response()->json(['error' => $validator->errors()], 422);
            }
        }
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {


            $fileName = '';
            if (isset($input['images']) && !empty($input['images']))
            {
                $image=$input['images'];

                $allowedfileExtension=['jpeg','jpg','png'];
                $files = $request->file('images');



                // if(count(is_countable($files) > 10))
                // {
                //     return response()->json(['error' => 'You can upload only 10 images'], 422);
                // }
                $fileName = array();
                $i = 1;
                if(!empty($request->file('images')))
                {
                    foreach ($request->file('images') as $file) 
                    {
                        $extension = $file->getClientOriginalExtension();
                        $check = in_array($extension,$allowedfileExtension);

                        if($check) 
                        {
                            $url = URL::to("/");
                            $name = time().$i.'.'.$file->extension();
                            $fileName[] = $name;

                            $file->move(public_path().'/realEstate/', $name);  
                            $data[] = $name;

                        }
                        else
                        {
                            return response()->json(['invalid_file_format'], 422);
                        }
                        $i++;
                    }
                }
                else
                {
                    foreach ($request->images as $file) 
                    {
                        $extension = $file->getClientOriginalExtension();
                        $check = in_array($extension,$allowedfileExtension);

                        if($check) 
                        {
                            $url = URL::to("/");
                            $name = time().$i.'.'.$file->extension();
                            $fileName[] = $name;

                            $file->move(public_path().'/realEstate/', $name);  
                            $data[] = $name;

                        }
                        else
                        {
                            return response()->json(['invalid_file_format'], 422);
                        }
                        $i++;
                    }
                }
                
                $input['imagesss'] = json_encode(['image' => $fileName]);
                
            }
            if(isset($input['facilities']))
            {
                $facilities = implode(',', $input['facilities']);
            }
            else
            {
                $facilities = '';
            }
            if($request->lease_length == '3 Months')
            {
                $leaselength = 3;
            }
            elseif($request->lease_length == '6 Months')
            {
                $leaselength = 6;
            }
            elseif($request->lease_length == '9 Months')
            {
                $leaselength = 9;
            }
            elseif($request->lease_length == '1 Year')
            {
                $leaselength = 12;
            }
            elseif($request->lease_length == '2 Year')
            {
                $leaselength = 24;
            }
            elseif($request->lease_length == '3 Year')
            {
                $leaselength = 36;
            }
            else
            {
                $leaselength = '';
            }

            if(isset($input['imagesss']))
            {
                RealEstate::create([
                    'company_id' => $request->company_id,
                    'user_id' => $request->user_id,
                    'agent_id' => $request->agent_id,
                    'title' => $request->title,
                    'price' => $request->price,
                    'beds' => $request->beds,
                    'baths' => $request->baths,
                    'furnished' => $request->furnished,
                    'lease_length' => $leaselength,
                    'availability' => $request->availability,
                    'enquiry_by' => $request->enquiry_by,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'images' => $input['imagesss'],
                    'facilities' => $facilities,
                    'description' => $request->description,
                    'address' => $request->address,
                    'status' => $request->status,
                    'property_type' => $request->property_type,
                ]);
            }
            else
            {
                RealEstate::create([
                    'company_id' => $request->company_id,
                    'user_id' => $request->user_id,
                    'agent_id' => $request->agent_id,
                    'title' => $request->title,
                    'price' => $request->price,
                    'beds' => $request->beds,
                    'baths' => $request->baths,
                    'furnished' => $request->furnished,
                    'lease_length' => $leaselength,
                    'availability' => $request->availability,
                    'enquiry_by' => $request->enquiry_by,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'facilities' =>  $facilities,
                    'description' => $request->description,
                    'address' => $request->address,
                    'status' => $request->status,
                    'property_type' => $request->property_type,
                ]);
            }
            $deviceTokens = AppUsers::where('deviceToken', '!=', '')->pluck('deviceToken');
            if (count($deviceTokens) > 0) {
                try {
                    $title = 'New Property Added';
                    $body = 'New Property Available';
                    $type = 'real-estate';
                    $res = $notification->apiNotification($deviceTokens, $body, $title, $type,$request->company_id);
                    // return response()->json(['status' => 1, 'msg' => 'Service Added Successfully!!']);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }
            return response()->json(['success' => 'Property Added SuccessFully'], 200);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitIssueRequest  $unitIssueRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) 
        {
            return response()->json(['error' => $validator->errors()], 422);
        } 
        else 
        {
            $realeStates = RealEstate::where('id', $request->id)->first();
            if (isset($realeStates)) {
                return response()->json(['data' => $realeStates], 200);
            } else {
                return response()->json(['error' => 'Issue Not Found'], 422);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitIssueRequest  $unitIssueRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input=$request->all();

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'required',
            'company_id' => 'required',
            'user_id' => 'required',
            'price' => 'required',
            'beds' => 'required',
            'baths' => 'required',
            'furnished' => 'required',
            'lease_length' => 'required',
            'availability' => 'required',
            'enquiry_by' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'facilities' => 'required',
            'description' => 'required',
            'status' => 'required',
            'property_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $realeStates = RealEstate::where('id', $request->id)->first();
            if (isset($realeStates)) {

                //// Deleted Images Start
                if(empty($input['images']))
                {
                    if(isset($input['deleted_images']))
                    {
                        if(!is_array($input['deleted_images']))
                        {
                            $imagesArray = explode(',',$input['deleted_images']);

                            $existedimages = json_decode($realeStates->images);
                            $arryexistedimages = $existedimages->image;

                            $resultMain = array();
                            foreach ($arryexistedimages as $arryexistedimageskey => $arryexistedimagesvalue){

                                if(!in_array($arryexistedimagesvalue, $imagesArray))
                                {
                                    $resultMain[$arryexistedimageskey]=$arryexistedimagesvalue;
                                }
                            }
                            $stringArray = implode(",",$resultMain);
                            $Arraystring = explode(",", $stringArray);
                            $resultArrays = json_encode(['image' => $Arraystring]);
                            if(!empty($stringArray))
                            {
                                RealEstate::where('id',$request->id)->update([
                                    'images'=>$resultArrays,
                                ]);
                            }
                            else
                            {
                                RealEstate::where('id',$request->id)->update([
                                    'images'=> null,
                                ]);
                            }
                        }
                    }
                }
                
                //// Deleted Images End

                if(isset($input['facilities']))
                {
                    $facilities = implode(',',$input['facilities']);
                }
                else
                {
                    $facilities = '';
                }

                if($request->lease_length == '3 Months')
                {
                    $leaselength = 3;
                }
                elseif($request->lease_length == '6 Months')
                {
                    $leaselength = 6;
                }
                elseif($request->lease_length == '9 Months')
                {
                    $leaselength = 9;
                }
                elseif($request->lease_length == '1 Year')
                {
                    $leaselength = 12;
                }
                elseif($request->lease_length == '2 Year')
                {
                    $leaselength = 24;
                }
                elseif($request->lease_length == '3 Year')
                {
                    $leaselength = 36;
                }
                else
                {
                    $leaselength = '';
                }

                if (isset($input['images']) && !empty($input['images']))
                {   
                    // if(!empty($feed->properties))
                    // {
                    //     RealEstate::where('id',$input['feed_id'])
                    //     ->update([
                    //         'images' => '',
                    //     ]);
                    // }
                    $rules = array(
                        'images[]' => 'image|mimes:jpeg,png,jpg'
                    );
                    $messages = [
                        'images[].mimes' => 'Only jpeg,png and jpg images are allowed',
                        'images[].max' => 'Sorry! Maximum allowed size for an image is 2MB'
                    ];
                    $validator = Validator::make($request->all(), $rules,$messages);
                    if ($validator->fails())
                    {
                        return $this->sendError($validator->errors()->all());
                    }

                    $fileName = '';
                    if (isset($input['images']) && !empty($input['images']))
                    {
                        $image=$input['images'];

                        $allowedfileExtension=['jpeg','jpg','png'];
                        $files = $request->file('images');
                        if(count($files) > 10)
                        {
                            return response()->json(['error' => 'You can upload only 10 images'], 422);
                        }

                        $fileName = array();
                        $i = 1;
                        foreach ($request->file('images') as $file) 
                        {
                            $extension = $file->getClientOriginalExtension();
                            $check = in_array($extension,$allowedfileExtension);

                            if($check) 
                            {

                                $name = time().$i.'.'.$file->extension();
                                $fileName[] = $name;

                                $file->move(public_path().'/realEstate/', $name);  
                                $data[] = $name;

                            }
                            else
                            {
                                return response()->json(['invalid_file_format'], 422);
                            }
                            $i++;
                        }


                        // $input['images'] = json_encode(['image' => $fileName]);


                        if(isset($input['deleted_images']) && !empty($input['deleted_images']))
                        {
                            if(!is_array($input['deleted_images']))
                            {
                                $imagesArray = explode(',',$input['deleted_images']);

                                $existedimages = json_decode($realeStates->images);
                                $arryexistedimages = $existedimages->image;

                                $resultMain = array();
                                foreach ($arryexistedimages as $arryexistedimageskey => $arryexistedimagesvalue){

                                    if(!in_array($arryexistedimagesvalue, $imagesArray))
                                    {
                                        $resultMain[$arryexistedimageskey]=$arryexistedimagesvalue;
                                    }
                                }
                                $stringArray = implode(",",$resultMain);
                                $Arraystring = explode(',', $stringArray);
                            // $resultArrays = json_encode(['image' => $Arraystring]);

                            }
                        }

                        if(isset($Arraystring))
                        {
                            $allMergeArray = array_merge($Arraystring,$fileName);
                            $input['images'] = json_encode(['image' => $allMergeArray]);
                        }
                        else
                        {
                            $existedimages = json_decode($realeStates->images);
                            $arryexistedimages = $existedimages->image;
                            if(isset($arryexistedimages))
                            {
                                $allMergeArray = array_merge($arryexistedimages,$fileName);
                                $input['images'] = json_encode(['image' => $allMergeArray]);
                            }
                            else
                            {
                                $input['images'] = json_encode(['image' => $fileName]);
                            }
                        }

                    }

                    

                    $realeStates->update([
                        'company_id' => $request->company_id,
                        'user_id' => $request->user_id,
                        'agent_id' => $request->agent_id,
                        'title' => $request->title,
                        'price' => $request->price,
                        'beds' => $request->beds,
                        'baths' => $request->baths,
                        'furnished' => $request->furnished,
                        'lease_length' => $leaselength,
                        'availability' => $request->availability,
                        'enquiry_by' => $request->enquiry_by,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'images' => $input['images'],
                        'facilities' => $facilities,
                        'description' => $request->description,
                        'address' => $request->address,
                        'status' => $request->status,
                        'property_type' => $request->property_type,
                    ]);

                }
                else
                {
                    $realeStates->update([
                        'company_id' => $request->company_id,
                        'user_id' => $request->user_id,
                        'agent_id' => $request->agent_id,
                        'title' => $request->title,
                        'price' => $request->price,
                        'beds' => $request->beds,
                        'baths' => $request->baths,
                        'furnished' => $request->furnished,
                        'lease_length' => $leaselength,
                        'availability' => $request->availability,
                        'enquiry_by' => $request->enquiry_by,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'facilities' => $facilities,
                        'description' => $request->description,
                        'address' => $request->address,
                        'status' => $request->status,
                        'property_type' => $request->property_type,
                    ]);
                }

                
                return response()->json(['success' => 'Real Estate Update SuccessFully'], 200);
            } else {
                return response()->json(['error' => 'RealEstate Not Found'], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitIssueRequest  $unitIssueRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $issue = UnitIssueRequest::where('id', $request->id)->first();
        if (isset($issue)) {
            $issue->delete();
            return response()->json(['data' => $issue], 200);
        } else {
            return response()->json(['error' => 'Issue Not Found'], 422);
        }
    }

    public function detailRealEstate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } 
        else 
        {
            $realEstatesDetail = RealEstate::leftjoin('companies', 'real_estates.company_id', '=', 'companies.id')
            ->leftjoin('app_users as c', 'c.id', '=', 'real_estates.user_id')
            ->leftjoin('agents', 'real_estates.agent_id', '=', 'agents.id')
            ->select([
                'real_estates.*',
                'agents.id as agent_id',
                'agents.company_id as agent_compnay_id',
                'agents.agent_name',
                'agents.agent_email',
                'agents.agent_phone_no',
                'companies.id as company_id',
                'companies.company_name',
                DB::raw('CONCAT(c.first_name," ",c.last_name) AS username')
            ])->where('real_estates.id',$request->id)->first();
            
            
            if (!empty($realEstatesDetail)) {
                //print_r($realEstatesDetail->images); 
                $datatat = json_decode($realEstatesDetail->images);
                $property_array = [];
                if (!empty($datatat->image)) {
                    foreach ($datatat->image as $image_key => $image_value) {
                        if(!empty($image_value)) {
                            $property_array[] = url('public/realEstate/').'/'.$image_value;
                        }
                    }   
                } else if (!empty($realEstatesDetail->images)) {
                    
                  $property_array[] = url('public/realEstate/'). '/'. trim($realEstatesDetail->images);
                }
                
                $realEstatesDetail->images = $property_array;
            }

            
            if (isset($realEstatesDetail)) {
                return response()->json(['data' => $realEstatesDetail], 200);
            } else {
                return response()->json(['error' => 'No record Found'], 422);
            }
        }
    }

    public function searchFilters(Request $request)
    {
        $input =  $request->all();
        $query = RealEstate::query();
        $query = RealEstate::leftjoin('companies', 'real_estates.company_id', '=', 'companies.id')
        ->leftjoin('agents', 'real_estates.agent_id', '=', 'agents.id')
        ->select([
            'real_estates.*',
            'agents.id as aid',
            'agents.company_id as acompany_id',
            'agents.agent_name',
            'agents.agent_email',
            'agents.agent_phone_no',
            'companies.id as company_id',
            'companies.company_name'
        ]);
        
        if (isset($input['minPrice']) && $input['maxPrice']!='') {
            $query = $query->whereBetween('price', [$input['minPrice'], $input['maxPrice']]);
        }
        
        if (isset($input['minBeds']) && $input['maxBeds']!='') {
            $query = $query->whereBetween('beds', [$input['minBeds'], $input['maxBeds']]);
        }
        
        if (isset($input['minBaths']) && $input['maxBaths']!='') {
            $query = $query->whereBetween('baths', [$input['minBaths'], $input['maxBaths']]);
        }
        
        if (isset($input['minLeaseLength']) && $input['maxLeaseLength']!='') {
            $query = $query->whereBetween('lease_length', [$input['minLeaseLength'], $input['maxLeaseLength']]);
        }
        
        if (isset($input['furnished']) && $input['furnished'] =='True') 
        {
            $query = $query->Where('furnished', 'LIKE', '%Yes%');
        }
        
        if (isset($input['furnished']) && $input['furnished'] =='False')
        {
            $query = $query->Where('furnished', 'LIKE', '%No%');
        }
        
        if (isset($input['property_type']) && $input['property_type']!='') {
            $query = $query->Where('property_type', 'LIKE', '%'.$input['property_type'].'%');
        }
        
        if (isset($input['sortBy']) && $input['sortBy'] == 'priceLow') {
            $searchResult = $query->orderby('price','ASC')
            ->get();
        }
        if (isset($input['sortBy']) && $input['sortBy'] == 'priceHigh') {
            $searchResult = $query->orderby('price','DESC')
            ->get();
        }
        
        if (isset($input['sortBy']) && $input['sortBy'] == 'recent') {
            $searchResult = $query->orderby('created_at','DESC')
            ->get();
        }
        
        $searchResult = $query->orderby('created_at','DESC')
        ->get();    
        
        
        if (!empty($searchResult)) 
        {
            foreach ($searchResult as $key => $singleFeeds) 
            {
                $datatat = json_decode($searchResult[$key]->images);
                $property_array = [];
                if (!empty($datatat->image)) 
                {
                    foreach ($datatat->image as $image_key => $image_value) {

                        if(!empty($image_value))
                        {
                            $property_array[] = url('public/realEstate/').'/'.$image_value;
                        }
                        else
                        {

                        }

                    }   
                }

                $searchResult[$key]->images = $property_array;
            }
        }

        $group = array();
        $companyId = "";
        foreach ( $searchResult as $value ) {
            if (empty($companyId ) || $companyId != $value['company_id']) {
              $companyId = $value['company_id'];     
              $group[$companyId]['buildingName'] = $value['company_name'];
              $group[$companyId]['items'][] = $value;
            } else {
              $group[$companyId]['items'][] = $value;
            } 
        }


      $perPage = 10;
      $options = [];
      $page = null;
      $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
      $items = $group instanceof Collection ? $group : Collection::make($group);

      if (isset($group)) {
        return response()->json(new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options), 200);
      } else {
        return response()->json(['error' => 'No record Found'], 422);
      }
        
        
        // if(count($searchResult)==0){
        //     return response()->json(['error' => 'Sorry, we cannot find a Property related to search'], 422);
        // } else {
        //     return response()->json(['property' => $searchResult], 200);
        // }
    }

    public function ownrealState(Request $request)
    {
        $realestates = RealEstate::leftjoin('companies', 'real_estates.company_id', '=', 'companies.id')
        ->leftjoin('agents', 'real_estates.agent_id', '=', 'agents.id')
        ->select([
            'real_estates.*',
            'agents.id as agent_id',
            'agents.agent_name',
            'agents.agent_email',
            'agents.agent_phone_no',
            'companies.company_name'
        ])
        ->where('real_estates.user_id',$request->user_id)
        ->where('real_estates.company_id',$request->company_id)
        ->orderBy('real_estates.id', 'desc')->paginate(10);

        if (!empty($realestates)) 
        {
            foreach ($realestates as $key => $singleFeeds) 
            {
                $datatat = json_decode($realestates[$key]->images);
                $property_array = [];
                if (!empty($datatat->image)) 
                {
                    foreach ($datatat->image as $image_key => $image_value) {
                        $property_array[] = url('public/realEstate/').'/'.$image_value;
                    }   
                }

                $realestates[$key]->images = $property_array;
            }
        }
        
        if (isset($realestates)) {
            return response()->json(['data' => $realestates], 200);
        } else {
            return response()->json(['error' => 'No record Found'], 422);
        }
    }

    public function deleterealEstate(Request $request)
    {
        $rules = array(
            'property_id' => 'required|numeric',
            'company_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        );
        $messages = [
            'property_id.required' => 'RealEstate Id field is required'
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all());
        }
        $input=$request->all();
        $feed=RealEstate::where('id',$input['property_id'])->where('company_id',$input['company_id'])->where('user_id',$input['user_id'])->first();
        if(isset($feed)){
            $feed->delete();
            $success['message'] = 'Real Estate Deleted successful';
            return $this->sendResponse($success);
        }else{
            $error = 'Real Estate Not available';
            return $this->sendError($error, 401);
        }
    }

    public function rentEstate(Request $request)
    {
        // $realestates = RealEstate::leftjoin('companies', 'real_estates.company_id', '=', 'companies.id')
        // ->leftjoin('agents', 'real_estates.agent_id', '=', 'agents.id')
        // ->select([
        //     'real_estates.*',
        //     'agents.id as aid',
        //     'agents.company_id as acompany_id',
        //     'agents.agent_name',
        //     'agents.agent_email',
        //     'agents.agent_phone_no',
        //     'companies.company_name'
        // ])
        // ->orderBy('real_estates.id', 'desc')->paginate(10);

        // if (!empty($realestates)) 
        // {
        //     foreach ($realestates as $key => $singleFeeds) 
        //     {
        //         $datatat = json_decode($realestates[$key]->images);
        //         $property_array = [];
        //         if (!empty($datatat->image)) 
        //         {
        //             foreach ($datatat->image as $image_key => $image_value) {
        //                 $property_array[] = url('public/realEstate/').'/'.$image_value;
        //             }   
        //         }

        //         $realestates[$key]->images = $property_array;
        //     }
        // }

        // if (isset($realestates)) {
        //     return response()->json(['data' => $realestates], 200);
        // } else {
        //     return response()->json(['error' => 'No record Found'], 422);
        // }

        $realestates = RealEstate::leftjoin('companies', 'real_estates.company_id', '=', 'companies.id')
        ->leftjoin('agents', 'real_estates.agent_id', '=', 'agents.id')
        ->where('real_estates.property_type','For Rent')
        ->select([
            'real_estates.*',
            'agents.id as aid',
            'agents.company_id as acompany_id',
            'agents.agent_name',
            'agents.agent_email',
            'agents.agent_phone_no',
            'companies.id as company_id',
            'companies.company_name'
        ])
        ->orderBy('real_estates.id', 'desc')->get();
        
        if (!empty($realestates)) 
        {
            foreach ($realestates as $key => $singleFeeds) 
            {
                $datatat = json_decode($realestates[$key]->images);
                $property_array = [];
                if (!empty($datatat->image)) 
                {
                    foreach ($datatat->image as $image_key => $image_value) {

                        if(!empty($image_value))
                        {
                            $property_array[] = url('public/realEstate/').'/'.$image_value;
                        }
                        else
                        {

                        }

                    }   
                }

                $realestates[$key]->images = $property_array;
            }
        }

        $group = array();
        $companyId = "";
        foreach ( $realestates as $value ) {
            if (empty($companyId ) || $companyId != $value['company_id']) {
             $companyId = $value['company_id'];     
             $group[$companyId]['buildingName'] = $value['company_name'];
             $group[$companyId]['items'][] = $value;
         } else {
          $group[$companyId]['items'][] = $value;
      } 
  }


  $perPage = 10;
  $options = [];
  $page = null;
  $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
  $items = $group instanceof Collection ? $group : Collection::make($group);

  if (isset($group)) {
    return response()->json(new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options), 200);
} else {
    return response()->json(['error' => 'No record Found'], 422);
}
}

}
