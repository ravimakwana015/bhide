<?php

namespace App\Http\Controllers\Admin\Company;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\User;
use App\Models\Company;
use App\Mail\SubscriptionPaymentMail;
use App\Mail\SendLoginDetailsMail;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Company\StripePlanController;

class CompanyController extends Controller
{
    protected $stripePlan;
    /**
     *
     *
     * @param StripePlanController $stripePlan
     */
    public function __construct(StripePlanController $stripePlan)
    {
        $this->stripePlan = $stripePlan;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allcompany = Company::get();
        $companys = [];
        $companys[''] = 'Select Company';
        
        foreach ($allcompany as $unit) {
            $companys[$unit->id] = $unit->company_name;
        }
        return view('admin.companies.index',compact('companys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'person_name' => 'required',
            'email' => 'required|unique:companies',
            'mobile' => 'required|unique:companies',
            'landline' => 'required|unique:companies',
            // 'apartment_count' => 'required|numeric',
            // 'subscription_amount' => 'required',
            'subscription_time' => 'required',
            'building_address' => 'required',
            'company_address' => 'required',
            'building_image' => 'required',
        ]);
        $input = $request->all();
        
        $user = User::create([
            'name' => $input['person_name'],
            'email' => $input['email'],
            'password' => bcrypt($input['email']),
            'user_type' => 'company',
        ]);
        $input['user_id'] = $user->id;
        $input['subscription_amount'] = $input['apartment_count'] * $input['per_apartment_amount'];


        if($input['payment_type'] == 1)
        {

            $company = Company::create([
                'company_name' => $input['company_name'],
                'user_id' => $user->id,
                'person_name' => $input['person_name'],
                'email' => $input['email'],
                'mobile' => $input['mobile'],
                'landline' => $input['landline'],
                'subscription_time' => $input['subscription_time'],
                'apartment_count' => $input['apartment_count'],
                'per_apartment_amount' => $input['per_apartment_amount'],
                'building_address' => $input['building_address'],
                'company_address' => $input['company_address'],
                'building_image' => $input['image_name'],
                'package_amount' => $input['package_amount'],
                'payment_type' => $input['payment_type'],
                'payment_status' => 1,
                'subscription_amount' => $input['subscription_amount'],
            ]);

            Mail::to($user->email)->send(new SendLoginDetailsMail($user,$user->email));
            Session::flash('success', "Company added Successfully !!");
            return redirect()->route('companies.index');
        }
        else
        {

            $company = Company::create([
                'company_name' => $input['company_name'],
                'user_id' => $user->id,
                'person_name' => $input['person_name'],
                'email' => $input['email'],
                'mobile' => $input['mobile'],
                'landline' => $input['landline'],
                'subscription_time' => $input['subscription_time'],
                'apartment_count' => $input['apartment_count'],
                'per_apartment_amount' => $input['per_apartment_amount'],
                'building_address' => $input['building_address'],
                'company_address' => $input['company_address'],
                'building_image' => $input['image_name'],
                'package_amount' => $input['package_amount'],
                'payment_type' => $input['payment_type'],
                'subscription_amount' => $input['subscription_amount'],
            ]);

            $response = $this->createSubscription($company);
            if ($response['status'] == false) {
                $company->delete();
                $user->delete();
                Session::flash('warning', $response['error']);
                return redirect()->route('companies.index');
            } else {
                Session::flash('success', "Company added Successfully !!");
                return redirect()->route('companies.index');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        \Stripe\Stripe::setApiKey(config('cashier.secret'));
        $user = User::where('email', $company->email)->first();
        $invoices = [];
        $subscription = [];
        if (isset($user)) {
            $invoices = $user->invoices();
        }
        if(isset($user->subscription('main')->stripe_id)){
            $subscription = \Stripe\Subscription::retrieve($user->subscription('main')->stripe_id);
        }
        return view('admin.companies.show', compact('company', 'invoices', 'user','subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'person_name' => 'required',
            'mobile' => 'required|unique:companies,mobile,' . $company->id,
            'landline' => 'required|unique:companies,landline,' . $company->id,
            'company_address' => 'required',
        ]);
        $input = $request->all();

        // $input=$request->except('image_name');
        $company->update([
            'company_name' => $input['company_name'],
            'person_name' => $input['person_name'],
            'mobile' => $input['mobile'],
            'landline' => $input['landline'],
            'company_address' => $input['company_address'],
        ]);

        if(isset($input['image_name']))
        {
            $company->update([
                'building_image' => $input['image_name']
            ]);
        }

        $company->companyUser->update([
            'name' => $input['person_name']
        ]);
        Session::flash('success', "Company details updated Successfully !!");
        return redirect()->route('companies.index');
        //Send new Payment email if subscription Amount change
        // if (isset($input['subscription_amount']) && $company->subscription_amount !== $input['subscription_amount'] && $company->payment_status == 0) {
        //     $response = $this->createSubscription($company);
        //     if ($response['status'] == false) {
        //         Session::flash('warning', $response['error']);
        //         return redirect()->route('companies.index');
        //     } else {
        //         $input['payment_status'] = 1;
        //         $company->update($input);
        //         Session::flash('success', "Company details updated Successfully !!");
        //         return redirect()->route('companies.index');
        //     }
        // } else {
        //     $company->update($input);
        //     Session::flash('success', "Company details updated Successfully !!");
        //     return redirect()->route('companies.index');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        $company->companyUser->delete();
        Session::flash('success', "Company details deleted Successfully !!");
        return redirect()->route('companies.index');
    }

    /**
     * Send Login Details to Company
     *
     * @param [type] $company_id
     * @return void
     */
    public function sendLoginDetails($company_id)
    {
        $password = Str::random(10);
        $company = Company::where('id', $company_id)->first();
        $user = User::where('email', $company->email)->first();
        if (isset($user)) {
            $user->update([
                'password' => bcrypt($password),
            ]);
            Mail::to($user->email)->send(new SendLoginDetailsMail($user, $password));

            echo "<pre>";
            echo "UserName = ".$user->email;
            echo "</pre>";
            echo "<pre>";
            echo "Password = ".$password;
            echo "</pre>";
            die();
            Mail::to($user->email)->send(new SendLoginDetailsMail($user, $password));
            
            Session::flash('success', "Login details sent to company Successfully!!");
            return redirect()->route('companies.index');
        } else {
            Session::flash('error', "User not available");
            return redirect()->route('companies.index');
        }
    }
    /**
     * Send Login Details to Company
     *
     * @param [type] $company_id
     * @return void
     */
    public function sendPaymentLink($company_id)
    {
        $company = Company::where('id', $company_id)->first();
        $this->sendSubscriptionPaymentMail($company, $company->plan_id);
        Session::flash('success', "Payment Link sent to company Successfully!!");
        return redirect()->route('companies.index');
    }
    /**
     * Download User invoice
     *
     * @param [type] $company_id
     * @param [type] $invoice_id
     * @return void
     */
    public function downloadInvoice($company_id, $invoice_id)
    {
        $user = User::where('id', $company_id)->first();
        return $user->downloadInvoice($invoice_id, [
            'vendor' => config('app.name'),
            'product' => 'invoice',
        ]);
    }


    /**
     * Create subscription plans for company
     *
     * @param object $company
     * @return void
     */
    public function createSubscription(object $company)
    {
        $plan = $this->stripePlan->createSubscriptionPlan($company);
        if ($plan['status'] == true) {
            $this->sendSubscriptionPaymentMail($company, $plan['plan']->id);
            return [
                'status' => true
            ];
        } else {
            return $plan;
        }
    }
    /**
     * Send a mail to company for subscription Mail
     *
     * @param object $company
     * @param string $plan_id
     * @return void
     */
    public function sendSubscriptionPaymentMail(object $company, string $plan_id)
    {
        $unique_id = $this->generateUniqueId();
        Company::where('id', $company->id)->update([
            'plan_id' => $plan_id,
            'unique_id' => $unique_id
        ]);
        $url = route('payment.details', [$unique_id]);
        return  Mail::to($company->email)->send(new SubscriptionPaymentMail($company, $url));
    }

    public function generateUniqueId()
    {
        $number = mt_rand(1000000000, 9999999999); // better than rand()
        if ($this->uniqueIdExists($number)) {
            return generateUniqueId();
        }
        return $number;
    }

    public function uniqueIdExists($number)
    {
        return Company::where('unique_id', $number)->exists();
    }

    public function uploadBuildingIcon(Request $request)
    {
        $input = $request -> all();

        list($type, $input['image']) = explode(';', $input['image']);
        list(, $input['image']) = explode(',', $input['image']);

        $data = base64_decode($input['image']);
        $image_name = time() . '.png';
        $path = public_path('front/building_image/').$image_name;
        //$path = '/public/front/building_image/'.$image_name;

        file_put_contents($path, $data);

        echo $image_name;
    }
}
