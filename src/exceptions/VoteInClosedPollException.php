<?php


namespace Inani\Larapoll\Exceptions;

use Exception;
class VoteInClosedPollException extends Exception
{
    /**
     * Create a new instance
     */
    public function __construct()
    {
        parent::__construct('投票已關閉，你無法再進行投票。');
    }
}