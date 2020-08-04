<?php

namespace Task\Repository;

use Money\Currency;
use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\ValueObject\Rate;

interface ExchangeRateRepositoryInterface
{
    /**
     *
     * @param Currency $currency
     * @return float
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function getRate(Currency $currency): Rate;
}