<?php

namespace Task\ValueObject\Base;

use Task\Exception\EmptyArgumentException;
use Task\Exception\NotFloatArgumentException;
use Task\Exception\NotIntArgumentException;

class IntValueObject
{
    /**
     * @var float
     */
    private $value;

    /**
     * @param float $value
     * @throws EmptyArgumentException
     * @throws NotFloatArgumentException
     */
    public function __construct($value)
    {
        if (empty($value)) {
            throw new EmptyArgumentException(get_called_class());
        }

        if (!is_integer($value)) {
            throw new NotIntArgumentException(get_called_class());
        }

        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}