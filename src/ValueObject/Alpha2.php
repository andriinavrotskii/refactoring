<?php

namespace Task\ValueObject;

class Alpha2
{
    /**
     * @var string
     */
    private $value;

    /**
     * Alpha2 constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
