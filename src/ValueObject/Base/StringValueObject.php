<?php

namespace Task\ValueObject\Base;

use Task\Exception\EmptyArgumentException;
use Task\Exception\NotStringArgumentException;

class StringValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     * @throws EmptyArgumentException
     * @throws NotStringArgumentException
     */
    public function __construct($value)
    {
        if (empty($value)) {
            throw new EmptyArgumentException('bin');
        }

        if (!is_string($value)) {
            throw new NotStringArgumentException('bin');
        }

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
