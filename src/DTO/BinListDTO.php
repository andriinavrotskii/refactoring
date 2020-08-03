<?php

namespace Task\DTO;

class BinListDTO
{
    /**
     * @var string
     */
    private $alpha2;

    /**
     * BinListDTO constructor.
     * @param string $alpha2
     */
    public function __construct(string $alpha2)
    {
        $this->alpha2 = $alpha2;
    }

    /**
     * @return string
     */
    public function getAlpha2(): string
    {
        return $this->alpha2;
    }
}
