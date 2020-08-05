<?php

declare(strict_types=1);

namespace Task\Exception;

class OutOfBondException extends \Exception
{
    /**
     * OutOfBondException constructor.
     * @param string $paramName
     */
    public function __construct(string $paramName)
    {
        parent::__construct('Param not found in input data. Param: ' . $paramName);
    }
}