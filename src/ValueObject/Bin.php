<?php

namespace Task\ValueObject;

use Task\Exception\EmptyArgumentException;
use Task\Exception\NotStringArgumentException;

class Bin
{
    /**
     * @var string
     */
    private $bin;

    /**
     * Bin constructor.
     * @param string $bin
     * @throws EmptyArgumentException
     * @throws NotStringArgumentException
     */
    public function __construct($bin)
    {
        if (empty($bin)) {
            throw new EmptyArgumentException('bin');
        }

        if (!is_string($bin)) {
            throw new NotStringArgumentException('bin');
        }

        $this->bin = $bin;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->bin;
    }
}
