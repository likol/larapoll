<?php

namespace Inani\Larapoll\Exceptions;

use Exception;

class RemoveVotedOptionException extends Exception
{
    /**
     * Create a new instance
     */
    public function __construct()
    {
        parent::__construct('你無法移除已被投過票的選項。');
    }
}