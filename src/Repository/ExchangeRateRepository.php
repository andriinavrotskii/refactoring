<?php

namespace Task\Repository;

use Task\Exception\NotFoundException;
use Task\Facade\UrlClientFacade;

class ExchangeRateRepository
{
    private const URL = 'https://api.exchangeratesapi.io/latest';

    /**
     * @var UrlClientFacade
     */
    private $urlClientFacade;

    /**
     * BinListRepository constructor.
     * @param UrlClientFacade $urlClientFacade
     */
    public function __construct(UrlClientFacade $urlClientFacade)
    {
        $this->urlClientFacade = $urlClientFacade;
    }

    public function getRate(string $currency): float
    {
        $data = $this->urlClientFacade->executeGetRequest(self::URL);
        $obj = json_decode($data);

        if (isset($obj->base) && $currency === $obj->base) {
            return (float) 1;
        }

        if (isset($obj->rates->$currency) && !empty($obj->rates->$currency) && is_float($obj->rates->$currency)) {
            return $obj->rates->$currency;
        }


        throw new NotFoundException('Rate is not found');
    }
}
