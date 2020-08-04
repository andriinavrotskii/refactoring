<?php

namespace Task\Exception;

use Throwable;

class TransactionCommissionServiceException extends \Exception
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
