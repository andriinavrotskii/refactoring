<?php

namespace Task\Repository;

use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\ValueObject\Bin;

interface BinListRepositoryInterface
{
    /**
     * @param Bin $bin
     * @return string
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function getAlpha2(Bin $bin): string;
}