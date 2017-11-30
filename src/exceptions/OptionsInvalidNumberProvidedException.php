<?php

namespace Inani\Larapoll\Exceptions;

use Exception;

class OptionsInvalidNumberProvidedException extends Exception
{
    /**
     * Create a new instance
     */
    public function __construct()
    {
        parent::__construct('你不能建立只有一個選項的投票。');
    }
}