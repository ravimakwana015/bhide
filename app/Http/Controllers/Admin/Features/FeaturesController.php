<?php

namespace App\Http\Controllers\Admin\Features;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Features;
use Session;

class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.features.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.features.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'title.required' => 'Please Enter Title',
            'content.required' => 'Please Enter Content',
            'feature_image.required' => 'Please Select Image',
        ];
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'feature_image' => 'required',
        ], $messages);

        $input['subtitle'] = json_encode($request->subtitle);
        $input['content'] = json_encode($request->content);

        if(isset($request->feature_image)) {
            $destinationPath = public_path('front/features_image/');
            $fileName_hover = time().'.'.request()->feature_image->getClientOriginalExtension();
            request()->feature_image->move($destinationPath, $fileName_hover);
        }

        $insertdata = Features::create([
            'title' => $request->title,
            'subtitle' => $input['subtitle'],
            'content' => $input['content'],     
            'feature_image' => $fileName_hover
        ]);

        Session::flash('success', "Feature Added Successfully !!");
        return redirect()->route('features.index');

    }

    public function storefeatures(Request $request)
    {
        $messages = [
            'title.required' => 'Please Enter Title',
            'content.required' => 'Please Enter Content',
            'feature_image.required' => 'Please Select Image',
        ];
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'feature_image' => 'required',
        ], $messages);

        if(isset($request->feature_image)) {
            $destinationPath = public_path('front/features_image/');
            $fileName_hover = time().'.'.request()->feature_image->getClientOriginalExtension();
            request()->feature_image->move($destinationPath, $fileName_hover);
        }

        $insertdata = Features::create([
            'title' => $request->title,
            'content' => $request->content,     
            'feature_image' => $fileName_hover
        ]);

        return json_encode(array('status'=>1));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companySettings = Features::find($id);

        return view('admin.features.edit',compact('companySettings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'title.required' => 'Please Enter Title',
            'content.required' => 'Please Enter Content',
        ];
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ], $messages);
        
        $facilityID = $request->id;

        $input['subtitle'] = json_encode($request->subtitle);
        $input['content'] = json_encode($request->content);


        if(isset($request->feature_image)) {
            $destinationPath = public_path('front/features_image/');
            $fileName_hover = time().'.'.request()->feature_image->getClientOriginalExtension();
            request()->feature_image->move($destinationPath, $fileName_hover);

            Features::where('id', $facilityID)->update([
                'title' => $request->title,
                'subtitle' => $input['subtitle'],
                'content' => $input['content'],     
                'feature_image' => $fileName_hover
            ]);
        }
        else
        {
            Features::where('id', $facilityID)->update([
                'title' => $request->title,
                'subtitle' => $input['subtitle'],
                'content' => $input['content']
            ]);
        }

        Session::flash('success', "Feature Update Successfully !!");
        return redirect()->route('features.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function editfeatures(Request $request,$id) {
        $data['pages'] = Features::find($id);

        $editData = view('admin.features.edit', $data)->render();

        return json_encode(array('status'=>1,'data'=>$editData));
    }

    public function updatefeatures(Request $request) {

        $messages = [
            'title.required' => 'Please Enter Title',
            'content.required' => 'Please Enter Content',
        ];
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ], $messages);
        
        $facilityID = $request->id;
        if(isset($request->feature_image)) {
            $destinationPath = public_path('front/features_image/');
            $fileName_hover = time().'.'.request()->feature_image->getClientOriginalExtension();
            request()->feature_image->move($destinationPath, $fileName_hover);

            Features::where('id', $facilityID)->update([
                'title' => $request->title,
                'content' => $request->content,     
                'feature_image' => $fileName_hover
            ]);
        }
        else
        {
            Features::where('id', $facilityID)->update([
                'title' => $request->title,
                'content' => $request->content
            ]);
        }

        return json_encode(array('status'=>1));
    }

    public function deletefeatures(Request $request)
    {
        $service = Features::find($request->id);
        $service->delete();
        Session::flash('error', "Feature Deleted Successfully !!");
        return redirect()->route('features.index');
    }
}
