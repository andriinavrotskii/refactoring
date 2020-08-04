<?php

namespace Task\Repository;

use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;

interface ExchangeRateRepositoryInterface
{
    /**
     *
     * @param string $currency
     * @return float
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function getRate(string $currency): float;
}