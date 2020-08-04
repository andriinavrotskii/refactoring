<?php

namespace Task\Exception;

class NotFloatArgumentException extends \Exception
{
    /**
     * @param float $argument
     */
    public function __construct(float $argument)
    {
        parent::__construct('Not float: ' . $argument);
    }
}
