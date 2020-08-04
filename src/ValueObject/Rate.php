<?php

namespace Task\ValueObject;

class Rate
{
    /**
     * @var float
     */
    private $value;

    /**
     * Rate constructor.
     * @param float $value
     */
    public function __construct($value)
    {
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
