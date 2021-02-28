<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\PollsVotes;
use App\Models\Polls;
use App\Http\Controllers\Controller;

class PollsController extends Controller
{

    public function polls(Request $request)
    {
        $polls = Polls::where('company_id', $request->company_id)->orderBy('id', 'desc')->paginate(10);
        if (isset($polls)) {
            return response()->json(['data' => $polls], 200);
        } else {
            return response()->json(['error' => 'polls Not Found'], 422);
        }
    }

    public function isPollConduct(Request $request)
    {
        $input = $request->all();
        $isVoted = PollsVotes::where('poll_id', $input['poll_id'])->where('user_id', $input['user_id'])->first();
        if (isset($isVoted)) {
            return response()->json(['isVoted' => 1], 200);
        } else {
            return response()->json(['isVoted' => 0], 200);
        }
    }
    public function selectPollOption(Request $request)
    {
        $input = $request->all();
        $isVoted = PollsVotes::where('poll_id', $input['poll_id'])->where('user_id', $input['user_id'])->first();
        if (isset($isVoted)) {
            return response()->json(['error' => 'Already Give your feedback'], 422);
        } else {
            PollsVotes::create([
                'user_id' => $input['user_id'],
                'poll_id' => $input['poll_id'],
                'option_id' => $input['option_id'],
            ]);
            return response()->json(['status' => true], 200);
        }
    }
    public function getPollResult(Request $request)
    {
        $input = $request->all();
        $poll = Polls::find($input['poll_id']);
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
                foreach ($poll->options as $option) {
                    if ($option['id'] == $key) {
                        $name = $option['option'];
                    }
                }
                $result[$key] = [
                    'name' => $name,
                    'per' => number_format((count($answer) / $total) * 100),
                ];
                // $result[$key] = number_format((count($answer) / $total) * 100);
            }
            $diffIds = array_diff($option_ids, $vote_option_ids);
            foreach ($diffIds as $id) {
                foreach ($poll->options as $option) {
                    if ($option['id'] == $id) {
                        $name = $option['option'];
                    }
                }
                $result[$id] = [
                    'name' => $name,
                    'per' => 0,
                ];
                // $result[$id] = 0;
            }
            sort($result);
            $master = [
                'poll' => $poll,
                'result' => $result,
            ];
            return response()->json(['status' => '1', 'data' => $master]);
        } else {
            $master = [
                'poll' => $poll,
            ];
            return response()->json(['status' => '1', 'data' => $master]);
        }
    }
}
