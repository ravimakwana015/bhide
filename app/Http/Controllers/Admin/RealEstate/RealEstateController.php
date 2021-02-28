<?php

namespace App\Http\Controllers\Admin\RealEstate;

use Yajra\Datatables\Datatables;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\RealEstate;
use App\Http\Controllers\Controller;

class RealEstateController extends Controller
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

        $this->site_logo_path = 'img' . DIRECTORY_SEPARATOR . 'ads' . DIRECTORY_SEPARATOR;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.realEstate.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.adverts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'image' => 'bail|required|file|max:5000kb|mimes:jpeg,png,jpg,gif',
            'redirect_url' => 'bail|required|url',
            'instagram_url' => 'bail|required|url',
            'title' => 'bail|required',
        ], [
            'redirect_url.required' =>  'Redirect Url is required',
            'redirect_url.url' =>  'Redirect Url format is invalid',
            'instagram_url.required' =>  'Instagram Url is required',
            'instagram_url.url' =>  'Instagram Url format is invalid',
            'image.required' =>  'Image is required',
            'image.image' =>  'Invalid image format',
            'image.max' =>  'Image size must be less than 5MB',
            'image.mimes' =>  'Image must be a file of type: jpeg, png, jpg.',
            'image.dimensions'     => 'Invalid image - should be minimum width 1024'
        ]);
        $reqData = $request->all();
        $reqData['status'] = $request->has('status') ? 1 : 0;
        if (isset($request->image) && !empty($request->image)) {
            $logo = $reqData['image'];
            $image_name = time() . $logo->getClientOriginalName();
            Storage::put($this->site_logo_path . $image_name, file_get_contents($logo->getRealPath()));
            $reqData['image'] = $image_name;
        }
        Adverts::create($reqData);
        return response()->json(['status' => 1, 'msg' => 'Advert is added successfully.']);
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'image' => 'bail|file|max:5000kb|mimes:jpeg,png,jpg,gif',
            'redirect_url' => 'bail|required|url',
            'instagram_url' => 'bail|required|url',
            'title' => 'bail|required',
        ], [
            'redirect_url.required' =>  'Redirect Url is required',
            'redirect_url.url' =>  'Redirect Url format is invalid',
            'instagram_url.required' =>  'Instagram Url is required',
            'instagram_url.url' =>  'Instagram Url format is invalid',
            'image.required' =>  'Image is required',
            'image.image' =>  'Invalid image format',
            'image.max' =>  'Image size must be less than 5MB',
            'image.mimes' =>  'Image must be a file of type: jpeg, png, jpg.',
            'image.dimensions'     => 'Invalid image - should be minimum width 1024'
        ]);
        $reqData = $request->all();
        $advert = Adverts::find($request->id);
        $reqData['status'] = $request->has('status') ? 1 : 0;

        if (isset($request->image) && !empty($request->image)) {
            $logo = $reqData['image'];
            $image_name = time() . $logo->getClientOriginalName();
            Storage::put($this->site_logo_path . $image_name, file_get_contents($logo->getRealPath()));
            $reqData['image'] = $image_name;
        }
        $advert->update($reqData);
        return response()->json(['status' => 1, 'msg' => 'Advert is Updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $advert = Adverts::find($request->id);
        $advert->delete();
        return redirect()->route('advert.index')->withStatus(__('Advert is deleted successfully.'));
    }

    public function editAdverts(Request $request) {

        $data['adverts'] = Adverts::find($request->id);
        $editData = view('admin.adverts.edit', $data)->render();
        return json_encode(array('status' => 1, 'data' => $editData));
    }

    public function getAdvert(Request $request)
    {
        return DataTables::make($this->getForDataTable($request->all()))
            ->editColumn('created_at', function ($advert) {
                return Carbon::parse($advert->created_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('updated_at', function ($advert) {
                return Carbon::parse($advert->updated_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('redirect_url', function ($advert) {
                return '<a href="' . $advert->redirect_url . '" target="_blank">' . $advert->redirect_url . '</a>';
            })
            ->editColumn('instagram_url', function ($advert) {
                return '<a href="' . $advert->instagram_url . '" target="_blank">' . $advert->instagram_url . '</a>';
            })
            ->editColumn('image', function ($advert) {
                return "<img src='" . asset('/storage/app/img/ads/') . "/" . $advert->image . "' width='80' height='80' id='career_img'>";
            })
            ->editColumn('status', function ($advert) {
                if ($advert->status == 1) {
                    return '<label class="btn btn-success btn-xs">Active</label>';
                } else  if ($advert->status == 0) {
                    return '<label class="btn btn-warning btn-xs">Inactive</label>';
                }
            })
            ->addColumn('actions', function ($advert) {
                return '<button type="button" class="btn btn-outline-info" onclick="getData(' . $advert->id . ')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit Parcel"><i class="fas fa-user-edit"></i></button>
     		<button type="button" class="btn btn-outline-danger" onclick="getDelete(' . $advert->id . ')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete Parcel"><i class="fas fa-trash"></i></button>';
            })
            ->rawColumns(['actions', 'image', 'status', 'redirect_url', 'instagram_url'])
            ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = Adverts::orderBy('id', 'desc');

        return  $dataTableQuery;
    }
}
