<?php

namespace Task\Exception;

class NotIntArgumentException extends \Exception
{
    /**
     * @param string $argument
     */
    public function __construct(string $argument)
    {
        parent::__construct('Not int: ' . $argument);
    }
}