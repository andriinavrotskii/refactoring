<?php

declare(strict_types=1);

namespace Task\ValueObject\Base;

use Task\Exception\EmptyArgumentException;
use Task\Exception\NotFloatArgumentException;

class FloatValueObject
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

        if (!is_float($value)) {
            throw new NotFloatArgumentException(get_called_class());
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
