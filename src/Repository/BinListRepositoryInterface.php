<?php

namespace Task\Repository;

use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\ValueObject\Alpha2;
use Task\ValueObject\Bin;

interface BinListRepositoryInterface
{
    /**
     * @param Bin $bin
     * @return Alpha2
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function getAlpha2(Bin $bin): Alpha2;
}