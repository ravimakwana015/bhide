<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\MemberIssueRequest;
use App\Models\UnitIssueRequest;
use App\Models\Company;
use App\Models\AppUsers;
use App\Http\Controllers\Controller;

class UnitIssueRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $issue = UnitIssueRequest::where('company_id', $request->company_id)
            ->where('unit_id', $request->unit_id)
            ->where('user_id', $request->user_id)
            ->orderBy('created_at', 'desc')->paginate(10);
        if (isset($issue) && count($issue)) {
            return response()->json(['data' => $issue], 200);
        } else {
            return response()->json(['error' => 'Issue Not Found'], 422);
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'issue' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {

            UnitIssueRequest::create([
                'company_id' => $request->company_id,
                'unit_id' => $request->unit_id,
                'user_id' => $request->user_id,
                'issue' => $request->issue,
                'status' => 0,
            ]);

            $company = Company::where('id', $request->company_id)->first();
            $companyUser = User::where('id', $company->user_id)->first();
            $appUser = AppUsers::where('id', $request->user_id)->first();
            $companyUser->notify(new MemberIssueRequest($appUser));
            return response()->json(['success' => $companyUser], 200);
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
        $issue = UnitIssueRequest::where('id', $request->id)->first();
        if (isset($issue)) {
            return response()->json(['data' => $issue], 200);
        } else {
            return response()->json(['error' => 'Issue Not Found'], 422);
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
        $validator = Validator::make($request->all(), [
            'issue' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $issue = UnitIssueRequest::where('id', $request->id)->first();
            if (isset($issue)) {
                $issue->update([
                    'issue' => $request->issue
                ]);
                return response()->json(['success' => 1], 200);
            } else {
                return response()->json(['error' => 'Issue Not Found'], 422);
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
}
