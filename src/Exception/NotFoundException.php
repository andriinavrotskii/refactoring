<?php

declare(strict_types=1);

namespace Task\Exception;

use Throwable;

class NotFoundException extends \Exception
{
    /**
     * @param string $message
     */
    public function __construct($message = "")
    {
        parent::__construct($message, 0, null);
    }
}
