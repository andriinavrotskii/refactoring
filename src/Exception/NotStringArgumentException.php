<?php

namespace Task\Exception;

class NotStringArgumentException extends \Exception
{
    /**
     * NotStringArgumentException constructor.
     * @param string $argument
     */
    public function __construct(string $argument)
    {
        parent::__construct('Not string: ' . $argument);
    }
}
