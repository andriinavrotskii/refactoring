<?php

declare(strict_types=1);

namespace Task\Exception;

class NotFloatArgumentException extends \Exception
{
    /**
     * @param string $argument
     */
    public function __construct(string $argument)
    {
        parent::__construct('Not float: ' . $argument);
    }
}
