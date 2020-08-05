<?php

declare(strict_types=1);

namespace Task\Exception;

class EmptyArgumentException extends \Exception
{
    /**
     * EmptyArgumentException constructor.
     * @param string $argument
     */
    public function __construct(string $argument)
    {
        parent::__construct('Empty argument: ' . $argument);
    }
}
