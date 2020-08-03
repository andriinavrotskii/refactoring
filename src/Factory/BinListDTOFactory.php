<?php

namespace Task\Factory;

use Task\DTO\BinListDTO;

class BinListDTOFactory
{
    /**
     * @param string $alpha2
     * @return BinListDTO
     */
    public function create(string $alpha2): BinListDTO
    {
        return new BinListDTO($alpha2);
    }
}
