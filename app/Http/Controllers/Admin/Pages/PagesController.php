<?php

namespace App\Http\Controllers\Admin\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pages;
use Session;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:pages',
            'status' => 'required',
        ],[
            'title.required' => 'Please Enter Page Title',
            'title.unique' => 'Page Already exist',
            'status.required' => 'Please Select Status',
        ]);

        $input = $request->all();
        Pages::create($input);
        
        return response()->json(['status' => 1, 'msg' => 'Page Added Successfully!!']);
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
        $pages = Pages::find($id);
        return view('admin.pages.edit',compact('pages'));
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
        $validatedData = $request->validate([
            'title' => 'required|unique:pages,title,'.$id.'',
           // 'content' => 'required',
            'status' => 'required',
        ],[
            'title.required' => 'Please Enter Page Title',
            'title.unique' => 'Page Already exist',
            //'content.required' => 'Please Enter Page Content',
            'status.required' => 'Please Select Status',
        ]);

        $update = $request->all();
        $pages = Page::find($id);
//        $slug = strtolower(str_replace(' ','-',trim($update['title'])));

        $pages->update($update);

        return redirect('admin/pages')->with('success','Page Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pagedelete = Pages::findOrFail($id);
        $pagedelete->delete();
        return redirect('admin/pages')->with('error','Page Deleted Successfully !!');
    }

    public function editpages(Request $request,$id) {
        $data['pages'] = Pages::find($id);

        $editData = view('admin.pages.edit', $data)->render();

        return json_encode(array('status'=>1,'data'=>$editData));
    }

    public function updatepages(Request $request) {

        $facilityID = $request->id;

        $validatedData = $request->validate([
            'title' => 'required',
            'status' => 'required',
        ],[
            'title.required' => 'Please Enter Page Title',
            'status.required' => 'Please Select Status',
        ]);

        Pages::where('id', $facilityID)->update([
            'title' => $request->title, 
            'content' => $request->content,
            'status' => $request->status
        ]);

        return json_encode(array('status'=>1));
    }

    public function deletepages(Request $request)
    {
        $service = Pages::find($request->id);
        $service->delete();
        Session::flash('error', "Page Deleted Successfully !!");
        return redirect()->route('pages.index');
    }

}
