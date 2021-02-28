<?php

namespace App\Http\Controllers\Polls;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PollsVotes;
use App\Models\PollsOptions;
use App\Models\Polls;
use App\Models\AppUsers;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Controller;

class PollsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('polls.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('polls.create');
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
            'status' => 'required',
            'poll_valid_until' => 'required',
            'options.*' => 'required',
        ]);
        $polls = Polls::create([
            'company_id' => Auth::user()->company->id,
            'title' => $input['title'],
            'status' => $input['status'],
            'poll_valid_until' => $input['poll_valid_until'],
        ]);
        if (isset($input['options']) && count($input['options'])) {
            foreach ($input['options'] as $option) {
                PollsOptions::create([
                    'poll_id' => $polls->id,
                    'option' => $option,
                ]);
            }
        }
        $deviceTokens = AppUsers::where('deviceToken', '!=', '')->pluck('deviceToken');
        if (count($deviceTokens) > 0) {
            try {
                $title = "New poll available";
                $body = 'New Poll Available in Apartment';
                $type = 'poll';
                $res = $notification->senNotification($deviceTokens, $body, $title, $type);
                if ($res['status'] == 1) {
                    return redirect()->route('polls.index')->with('success', 'Polls Added Successfully!!');
                } else {
                    return redirect()->route('polls.index')->with('success', 'Polls Added Successfully. Firebase Server Key No Available. Please Contact your Admin!!');
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return redirect()->route('polls.index')->with('success', 'Polls Added Successfully!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Polls  $polls
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poll = Polls::find($id);
        return view('polls.show', compact('poll'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Polls  $polls
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poll = Polls::find($id);
        return view('polls.edit', compact('poll'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Polls  $polls
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $poll = Polls::find($id);
        $input = $request->except('_token', '_method');
        $this->validate($request, [
            'title' => 'required',
            'status' => 'required',
            'poll_valid_until' => 'required',
            'options.*' => 'required',
        ]);
        $poll->update([
            'title' => $input['title'],
            'status' => $input['status'],
            'poll_valid_until' => $input['poll_valid_until'],
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
        return redirect()->route('polls.index')->with('success', 'Poll Update Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Polls  $polls
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poll = Polls::find($id);
        PollsVotes::where('poll_id', $poll->id)->delete();
        PollsOptions::where('poll_id', $poll->id)->delete();
        $poll->delete();
        return redirect()->route('polls.index')->with('success', 'Poll Deleted Successfully!!');
    }
    public function deleteOption(Request $request)
    {
        $input = $request->except('_token', '_method');
        if (isset($input['option_id'])) {
            PollsOptions::where('id', $input['option_id'])->delete();
        }
        return response()->json(['status' => 1]);
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
                $counts = PollsVotes::where('poll_id', $polls->id)->count();
                return '<a href="javascript:;" class="btn btn-danger addAttr" onclick="getPollUsers(' . $polls->id . ')"><span class="ul-btn__icon"><b style="color:white;">' . $counts . '</b></span></a>';
            })
            ->editColumn('status', function ($polls) {
                if ($polls->status == 1) {
                    return '<label class="btn btn-warning btn-xs">Active</label>';
                } else  if ($polls->status == 0) {
                    return '<label class="btn btn-success btn-xs">In Active</label>';
                }
            })
            ->addColumn('actions', function ($polls) {
                $actions = '<a href="javascript:;" class="btn btn-danger addAttr" onclick="getPollResult(' . $polls->id . ')"><span class="ul-btn__icon"><i class="fas fa-poll-h"></i> Poll Result</span></a> <a title="View Poll" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('polls.show', $polls->id) . '"> <span class="ul-btn__icon"><i class="fas fa-eye"></i></span>
            </a> <a title="Edit Poll" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('polls.edit', $polls->id) . '"> <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
            </a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("polls.destroy", $polls) . '" id="delete_' . $polls->id . '" onclick="deletePopup(' . $polls->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
                return $actions;
            })
            ->rawColumns(['actions', 'status', 'poll_submission'])
            ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = Polls::where('company_id', Auth::user()->company->id)->orderBy('id', 'desc');
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
            $result = [];
            $vote_option_ids = [];
            foreach ($answers as $key => $answer) {
                $total = count($poll->optionsVotes);
                $vote_option_ids[] = $key;
                $result[$key] = number_format((count($answer) / $total) * 100);
            }
            $diffIds = array_diff($option_ids, $vote_option_ids);
            foreach ($diffIds as $id) {
                $result[$id] = 0;
            }
            $html = view('polls.poll_result', compact('result', 'poll'))->render();
            return response()->json(['status' => '1', 'result' => $html]);
        } else {
            return response()->json(['status' => '0']);
        }
    }

    public function getPollUsers(Request $request)
    {
        $input = $request->all();
        $poll = Polls::find($input['id']);
        $pollUsers = PollsVotes::where('poll_id', $poll->id)->get();

        if (count($poll->optionsVotes)) {
            $users_name = [];
            foreach ($pollUsers as $key => $value) {
                $users_name[] = $value->UserDetails->first_name . ' ' . $value->UserDetails->middle_name . ' ' . $value->UserDetails->last_name . ' -- ' . Carbon::parse($value->created_at)->format('d/m/Y h:i:s A');
            }
            $html = view('polls.poll_result_users', compact('users_name'))->render();
            return response()->json(['status' => '1', 'result' => $html]);
        } else {
            return response()->json(['status' => '0']);
        }
    }
}
