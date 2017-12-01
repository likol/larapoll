<?php


namespace Inani\Larapoll\Traits;


use Inani\Larapoll\Exceptions\PollNotSelectedToVoteException;
use Inani\Larapoll\Exceptions\VoteInClosedPollException;
use Inani\Larapoll\Option;
use Inani\Larapoll\Poll;

trait Voter
{
    protected $poll;

    /**
     * Select poll
     *
     * @param Poll $poll
     * @return $this
     */
    public function poll(Poll $poll)
    {
        $this->poll = $poll;
        return $this;
    }

    /**
     * Vote for an option
     *
     * @param $options
     * @return bool
     * @throws PollNotSelectedToVoteException
     * @throws VoteInClosedPollException
     * @throws \Exception
     */
    public function vote($options)
    {
        $options = is_array($options)? $options : func_get_args();
        // if poll not selected
        if(is_null($this->poll))
            throw new PollNotSelectedToVoteException();

        if($this->poll->isLocked())
            throw new VoteInClosedPollException();

        if($this->hasVoted($this->poll))
            throw new \Exception("您已經投過票了。");

        // if is Radio and voted for many options
        $countVotes = count($options);
        if($this->poll->isRadio() && $countVotes > 1)
            throw new \InvalidArgumentException("該投票只能單選。");

        if($this->poll->isCheckable() &&  $countVotes > $this->poll->maxCheck)
            throw new \InvalidArgumentException("該投票最多可選 {$this->poll->maxCheck} 個項目，您選擇了 {$countVotes} 個");

        array_walk($options, function (&$val){
            if(! is_numeric($val))
                throw new \InvalidArgumentException("錯誤的參數。");
        });

        return !is_null($this->options()->sync($options, false)['attached']);
    }

    /**
     * Check if he can vote
     *
     * @param $poll_id
     * @return bool
     */
    public function hasVoted($poll_id)
    {
        $result = Poll
            ::join('options', 'polls.id', '=', 'options.poll_id')
            ->join('votes', 'votes.option_id', '=', 'options.id')
            ->select('option_id')
            ->where('user_id', $this->getKey())
            ->where('poll_id', $poll_id)
            ->getQuery()
            ->get();
        return count($result) != 0;
    }

    /**
     * The options he voted to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function options()
    {
        return $this->belongsToMany(Option::class, 'votes')->withTimestamps();
    }
}