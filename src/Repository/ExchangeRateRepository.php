<?php

declare(strict_types=1);

namespace Task\Repository;

use Money\Currency;
use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\Facade\UrlClientFacade;
use Task\ValueObject\Rate;

class ExchangeRateRepository implements ExchangeRateRepositoryInterface
{
    private const URL = 'https://api.exchangeratesapi.io/latest';

    /**
     * @var UrlClientFacade
     */
    private $urlClientFacade;

    /**
     * ExchangeRateRepository constructor.
     * @param UrlClientFacade $urlClientFacade
     */
    public function __construct(UrlClientFacade $urlClientFacade)
    {
        $this->urlClientFacade = $urlClientFacade;
    }

    /**
     * @param Currency $currency
     * @return Rate
     * @throws NotFoundException
     * @throws UrlClientException
     * @throws \Task\Exception\EmptyArgumentException
     * @throws \Task\Exception\NotFloatArgumentException
     */
    public function getRate(Currency $currency): Rate
    {
        $currencyValue = $currency->getCode();
        $rates = json_decode($this->urlClientFacade->executeGetRequest(self::URL));

        if (isset($rates->base) && $currencyValue === $rates->base) {
            $rate = (float) 1;
        } else {
            $this->validate($rates, $currencyValue);
            $rate = $rates->rates->$currencyValue;
        }

        return new Rate($rate);
    }

    /**
     * @param \stdClass $rates
     * @param string $currencyValue
     * @throws NotFoundException
     */
    private function validate(\stdClass $rates, string $currencyValue): void
    {
        if (
            isset($rates->rates->$currencyValue)
            && !empty($rates->rates->$currencyValue)
            && is_float($rates->rates->$currencyValue)
        ) {
            return;
        }

        throw new NotFoundException('Rate is not found');
    }
}
