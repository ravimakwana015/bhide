<?php

namespace App\Http\Controllers\Admin\Poll;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Polls;
use App\Models\Company;
use App\Models\PollsOptions;
use App\Models\PollsVotes;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Company::all();
        $companys = [];
        $companys[''] = 'Select Company Name';
        foreach ($units as $unit) {
            $companys[$unit->id] = $unit->company_name;
        }
        return view('admin.polls.index',compact('companys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Company::all();
        $companys = [];
        $companys[''] = 'Select Company Name';
        foreach ($units as $unit) {
            $companys[$unit->id] = $unit->company_name;
        }
        return view('admin.polls.create',compact('companys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token', '_method');
        $this->validate($request, [
            'title' => 'required',
            'status' => 'required',
            'options.*' => 'required',
        ]);
        $polls = Polls::create([
            'company_id' => $input['company_id'],
            'title'      => $input['title'],
            'status'     => $input['status'],
        ]);
        if (isset($input['options']) && count($input['options'])) {
            foreach ($input['options'] as $option) {
                PollsOptions::create([
                    'poll_id' => $polls->id,
                    'option' => $option,
                ]);
            }
        }
        return redirect()->route('poll.index')->with('success', 'Polls Added Successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poll = Polls::find($id);
        return view('admin.polls.show', compact('poll'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companys = Company::all();
        $poll = Polls::find($id);
        return view('admin.polls.edit', compact('poll','companys'));
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
        $poll = Polls::find($id);
        $input = $request->except('_token', '_method');
        $this->validate($request, [
            'company_id' => 'required',
            'title' => 'required',
            'status' => 'required',
            'options.*' => 'required',
        ]);
        $poll->update([
            'company_id' => $input['company_id'],
            'title' => $input['title'],
            'status' => $input['status'],
        ]);
        if (isset($input['options']) && count($input['options'])) {
            foreach ($input['options'] as $key => $option) {
                if (isset($input['id'][$key])) {
                    $option_id = $input['id'][$key];
                    $oldOption = PollsOptions::where('id', $option_id)->first();
                    if (isset($oldOption)) {
                        $oldOption->update([
                            'option' =>  $option
                        ]);
                    }
                } else {
                    PollsOptions::create([
                        'poll_id' => $poll->id,
                        'option' => $option,
                    ]);
                }
            }
        }
        return redirect()->route('poll.index')->with('success', 'Poll Update Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poll = Polls::find($id);
        PollsVotes::where('poll_id', $poll->id)->delete();
        PollsOptions::where('poll_id', $poll->id)->delete();
        $poll->delete();
        return redirect()->route('poll.index')->with('success', 'Poll Deleted Successfully!!');
    }


    public function getPolls(Request $request)
    {
        return DataTables::make($this->getForDataTable($request->all()))
        ->editColumn('created_at', function ($polls) {
            return Carbon::parse($polls->created_at)->format('d/m/Y h:i:s A');
        })
        ->editColumn('updated_at', function ($polls) {
            return Carbon::parse($polls->updated_at)->format('d/m/Y h:i:s A');
        })
        ->editColumn('poll_submission', function ($polls) {
            $counts = PollsVotes::where('poll_id',$polls->id)->count();
            return '<a href="javascript:;" class="btn btn-danger addAttr" onclick="getPollUsers(' . $polls->id .')"><span class="ul-btn__icon"><b style="color:white;">'.$counts.'</b></span></a>';
        })
        ->editColumn('status', function ($polls) {
            if ($polls->polls_status == 1) {
                return '<label class="btn btn-warning btn-xs">Active</label>';
            } else  if ($polls->polls_status == 0) {
                return '<label class="btn btn-success btn-xs">In Active</label>';
            }
        })
        ->addColumn('actions', function ($polls) {

            $actions = '<a href="javascript:;" class="btn btn-danger addAttr" onclick="getPollResult(' . $polls->id . ')"><span class="ul-btn__icon"><i class="fas fa-poll-h"></i> Poll Result</span></a> <a title="View Poll" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('poll.show', $polls->id) . '"> <span class="ul-btn__icon"><i class="fas fa-eye"></i></span>
            </a> <a title="Edit Poll" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('poll.edit', $polls->id) . '"> <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
            </a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("poll.destroy", $polls) . '" id="delete_' . $polls->id . '" onclick="deletePopup(' . $polls->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
            return $actions;
        })
        ->rawColumns(['actions', 'status','poll_submission'])
        ->make(true);
    }

    public function getForDataTable($input)
    {
        $dataTableQuery = Polls::leftJoin('companies', 'polls.company_id', '=', 'companies.id')
        ->select([
            'companies.person_name',
            'companies.company_name',
            'companies.id as company_id',
            'polls.id as id',
            'polls.title',
            'polls.status as polls_status',
            'polls.created_at',
        ]);
        if (isset($input['company_name']) && $input['company_name'] != '') {
            $dataTableQuery->where('companies.id',$input['company_name']);
        }
        return  $dataTableQuery;
    }

    public function getPollResult(Request $request)
    {
        $input = $request->all();
        $poll = Polls::find($input['id']);
        if (count($poll->optionsVotes)) {
            $answers = [];
            $option_ids = [];
            foreach ($poll->options as $option) {
                $option_ids[] = $option['id'];
            }
            foreach ($poll->optionsVotes as $vote) {
                $answers[$vote['option_id']][] = $vote;
            }
            $result=[];
            $vote_option_ids=[];
            foreach ($answers as $key => $answer) {
                $total = count($poll->optionsVotes);
                $vote_option_ids[]=$key;
                $result[$key] = number_format((count($answer) / $total) * 100);
            }
            $diffIds= array_diff($option_ids,$vote_option_ids);
            foreach($diffIds as $id){
                $result[$id] = 0;
            }
            $html = view('polls.poll_result',compact('result','poll'))->render();
            return response()->json(['status' => '1','result'=>$html]);
        } else {
            return response()->json(['status' => '0']);
        }
    }

}
