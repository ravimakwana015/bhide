<?php

namespace App\Http\Controllers\MessageBoard;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\MessageBoard;
use App\Models\AppUsers;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Controller;

class MessageBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('messageBoard.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('messageBoard.create');
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
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'notice_valid_until' => 'required',
        ]);
        $input['company_id'] = Auth::user()->company->id;
        $input['notice_valid_until'] = date("Y-m-d", strtotime(str_replace('/', '-', $input['notice_valid_until'])));
        MessageBoard::create($input);
        $deviceTokens = AppUsers::where('deviceToken', '!=', '')->pluck('deviceToken');
        if (count($deviceTokens) > 0) {
            try {
                $title = 'New Notice Available';
                $body = 'New Notice Available in Apartment';
                $type = 'Notice';
                $res = $notification->senNotification($deviceTokens, $body, $title, $type);
                if ($res['status'] == 1) {
                    return response()->json(['status' => 1, 'msg' => 'Notice Added Successfully!!']);
                } else {
                    return response()->json(['status' => 1, 'msg' => 'Notice Added Successfully. Firebase Server Key No Available. Please Contact your Admin!!']);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return response()->json(['status' => 1, 'msg' => 'Notice Added Successfully!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MessageBoard  $messageBoard
     * @return \Illuminate\Http\Response
     */
    public function show(MessageBoard $messageBoard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MessageBoard  $messageBoard
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $messageBoard = MessageBoard::find($id);
        $editService = view('messageBoard.edit_modal', compact('messageBoard'))->render();
        return response()->json(['status' => 1, 'html' => $editService]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MessageBoard  $messageBoard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messageBoard = MessageBoard::find($id);
        $input = $request->except('_token', '_method');
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'notice_valid_until' => 'required',
        ]);
        $input['notice_valid_until'] = date("Y-m-d", strtotime(str_replace('/', '-', $input['notice_valid_until'])));
        $messageBoard->update($input);
        return redirect()->route('messageBoard.index')->with('success', 'Notice updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MessageBoard  $messageBoard
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MessageBoard::find($id)->delete();
        return redirect()->route('messageBoard.index')->with('success', 'Notice deleted Successfully!!');
    }

    public function getMessageBoard(Request $request)
    {
        return DataTables::make($this->getForDataTable($request->all()))
            ->editColumn('created_at', function ($messageBoard) {
                return Carbon::parse($messageBoard->created_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('updated_at', function ($messageBoard) {
                return Carbon::parse($messageBoard->updated_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('notice_valid_until', function ($messageBoard) {
                return Carbon::parse($messageBoard->notice_valid_until)->format('d/m/Y');
            })
            ->editColumn('status', function ($polls) {
                if ($polls->status == 1) {
                    return '<label class="btn btn-warning btn-xs">Active</label>';
                } else  if ($polls->status == 0) {
                    return '<label class="btn btn-success btn-xs">In Active</label>';
                }
            })
            ->addColumn('actions', function ($messageBoard) {
                $actions = '<a title="Edit Visitor" class="btn btn-sm btn-outline-primary btn-icon" href="javascript:;" data-url="' . route('messageBoard.edit', $messageBoard->id) . '" id="edit_' . $messageBoard->id . '" onclick="editPopup(' . $messageBoard->id . ')" > <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
                </a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("messageBoard.destroy", $messageBoard) . '" id="delete_' . $messageBoard->id . '" onclick="deletePopup(' . $messageBoard->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
                return $actions;
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = MessageBoard::where('company_id', Auth::user()->company->id)->orderBy('id', 'desc');
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
