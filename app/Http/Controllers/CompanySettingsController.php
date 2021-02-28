<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CompanySettings;

class CompanySettingsController extends Controller
{
    /**
     * Site Logo Path.
     *
     * @var string
     */
    protected $site_logo_path;
    /**
     * Constructor.
     */
    public function __construct()
    {

        $this->site_logo_path = 'img' . DIRECTORY_SEPARATOR . 'loyaltyCard' . DIRECTORY_SEPARATOR;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companySettings = CompanySettings::where('company_id', Auth::user()->company->id)->first();
        
        if (!isset($companySettings) && empty($companySettings)) {
            CompanySettings::insertGetId([
                'company_id'    => Auth::user()->company->id
            ]);
            $companySettings = CompanySettings::find(Auth::user()->company->id);
            return view('settings.index', compact('companySettings'));
        } else {
            return view('settings.index', compact('companySettings'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanySettings  $companySettings
     * @return \Illuminate\Http\Response
     */
    public function show(CompanySettings $companySettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanySettings  $companySettings
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanySettings $companySettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanySettings  $companySettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $companySettings = CompanySettings::find($id);
        
        $input = $request->except('_token', '_method');
        
        if (isset($input['loyalty_card_image'])) {
            $this->validate($request, [
                'loyalty_card_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ],[
                'loyalty_card_image.max' => 'The loyalty card image may not be greater than 2mb.'
            ]);
            $logo = $input['loyalty_card_image'];
            $image_name = time() . $logo->getClientOriginalName();
            Storage::put($this->site_logo_path . $image_name, file_get_contents($logo->getRealPath()));
            $input['loyalty_card_image'] = $image_name;
        }
        $input['emergency_numbers'] = json_encode($input['emergency_numbers']);
        $input['emergency_captions'] = json_encode($input['emergency_captions']);

        if(isset($input['loyalty_cardimage']))
        {
            $companySettings->update([

                'emergency_numbers' => $input['emergency_numbers'],
                'emergency_captions' => $input['emergency_captions'],
                'loyalty_card_image' => $input['loyalty_cardimage']

            ]);
        }
        else
        {
            $companySettings->update([

                'emergency_numbers' => $input['emergency_numbers'],
                'emergency_captions' => $input['emergency_captions'],
                'loyalty_card_image' => $companySettings->loyalty_card_image

            ]);
        }

        
        return redirect()->route('companySettings.index')->with('success', 'Company Setting Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanySettings  $companySettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanySettings $companySettings)
    {
        //
    }


    public function uploadLoyaltyIcon(Request $request)
    {
        $input = $request->all();

        list($type, $input['image']) = explode(';', $input['image']);
        list(, $input['image']) = explode(',', $input['image']);

        $data = base64_decode($input['image']);
        $image_name = time() . '.png';
        $path = 'storage/app/img/loyaltyCard/'.$image_name;
        // $path = public_path('front/member_image/').$image_name;

        file_put_contents($path, $data);

        echo $image_name;
    }

}
