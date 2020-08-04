<?php

namespace Task\Repository;

use Task\Exception\NotFoundException;

interface ExchangeRateRepositoryInterface
{
    /**
     *
     * @param string $currency
     * @return float
     * @throws NotFoundException
     * @throws \Task\Exception\UrlClientException
     */
    public function getRate(string $currency): float;
}