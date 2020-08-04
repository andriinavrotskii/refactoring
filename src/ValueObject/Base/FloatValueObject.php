<?php

namespace Task\ValueObject\Base;

use Task\Exception\EmptyArgumentException;
use Task\Exception\NotfloatArgumentException;

class FloatValueObject
{
    /**
     * @var float
     */
    private $value;

    /**
     * @param float $value
     * @throws EmptyArgumentException
     * @throws NotfloatArgumentException
     */
    public function __construct($value)
    {
        if (empty($value)) {
            throw new EmptyArgumentException('bin');
        }

        if (!is_float($value)) {
            throw new NotFloatArgumentException('bin');
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
