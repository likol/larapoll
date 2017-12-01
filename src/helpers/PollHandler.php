<?php

namespace Inani\Larapoll\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Inani\Larapoll\Exceptions\CheckedOptionsException;
use Inani\Larapoll\Exceptions\OptionsInvalidNumberProvidedException;
use Inani\Larapoll\Exceptions\OptionsNotProvidedException;
use Inani\Larapoll\Exceptions\RemoveVotedOptionException;
use Inani\Larapoll\Poll;
use Illuminate\Http\Request;
use Psy\Exception\Exception;

class PollHandler {

    /**
     * Create a Poll from Request
     *
     * @param $request
     * @return Poll
     */
    public static function createFromRequest($request)
    {
        $poll = new Poll([
            'question' => $request['question'],
            'description' => $request['description'],
            'start_at' => $request['start_at'],
            'end_at' => $request['end_at']
        ]);
        $poll->addOptions($request['options']);

        if(array_key_exists('maxCheck', $request)){
            $poll->maxSelection($request['maxCheck']);
        }

        $poll->generate();

        return $poll;
    }

    public static function modify(Poll $poll, $data)
    {
        if(array_key_exists('count_check', $data)){
            $poll->canSelect($data['count_check']);
        }

        if(array_key_exists('close', $data)){
            if(isset($data['close']) && $data['close']){
                $poll->lock();
            }else{
                $poll->unLock();
            }
        }else{
            $poll->unLock();
        }

        if (array_key_exists('question', $data)){
            $poll->question = $data['question'];
            $poll->save();
        }

        if (array_key_exists('description', $data)){
            $poll->description = $data['description'];
            $poll->save();
        }

        if (array_key_exists('start_at', $data)){
            $poll->start_at = $data['start_at'];
            $poll->save();
        }

        if (array_key_exists('end_at', $data)){
            $poll->end_at = $data['end_at'];
            $poll->save();
        }
    }

    public static function modifyOptions(Poll $poll,Request $request)
    {
        $options = new Collection(['options' => $request->get('options'), 'votes' => $request->get('votes')]);
        foreach ($options->get('options') as $key => $name)
        {
            $votes = $options->get('votes')[$key];
            $poll->options()->where('id', $key)->update([
                'name' => $name,
                'votes' => $votes,
            ]);
        }
    }

    public static function getMessage(\Exception $e)
    {
        if($e instanceof OptionsInvalidNumberProvidedException || $e instanceof OptionsNotProvidedException)
            return '每個投票至少需要兩個選項';
        if($e instanceof RemoveVotedOptionException)
            return '該選項已被投過，無法移除';
        if($e instanceof CheckedOptionsException)
            return 'You should edit the number of checkable options first.';
    }
}