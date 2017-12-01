<?php

namespace App\Http\Controllers\Vote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inani\Larapoll\Poll;

class VoteManagerController extends Controller
{

    /**
     * Make a Vote
     *
     * @param Poll $poll
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function vote(Poll $poll, Request $request)
    {
        try{
            $vote = $request->user()
                ->poll($poll)
                ->vote($request->get('options'));
            if($vote){
                return back()->with('success', '投票完成。');
            }
        }catch (\Exception $e){
            return back()->with('errors', $e->getMessage());
        }
    }
}