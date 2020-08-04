<?php

namespace Task\Repository;

use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\Facade\UrlClientFacade;

class ExchangeRateRepository implements ExchangeRateRepositoryInterface
{
    private const URL = 'https://api.exchangeratesapi.io/latest';

    /**
     * @var UrlClientFacade
     */
    private $urlClientFacade;

    /**
     * @var CacheRepository
     */
    private $storageRepository;

    /**
     * BinListRepository constructor.
     * @param UrlClientFacade $urlClientFacade
     */
    public function __construct(UrlClientFacade $urlClientFacade, CacheRepository $storageRepository)
    {
        $this->urlClientFacade = $urlClientFacade;
        $this->storageRepository = $storageRepository;
    }

    /**
     *
     * @param string $currency
     * @return float
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function getRate(string $currency): float
    {
        if ($this->storageRepository->isKeyExists($currency)) {
            $rate = $this->storageRepository->getFromStorage($currency);
        } else {
            $rate = $this->getRateFromSource($currency);
            $this->storageRepository->setToStorage($currency, $rate);
        }

        return $rate;
    }

    /**
     * @param string $currency
     * @return float
     * @throws NotFoundException
     * @throws \Task\Exception\UrlClientException
     */
    private function getRateFromSource(string $currency): float
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
