<?php

namespace Task\Repository;

use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\Facade\UrlClientFacade;
use Task\ValueObject\Bin;

class BinListRepository implements BinListRepositoryInterface
{
    private const URL = 'https://lookup.binlist.net/';

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
     * @param CacheRepository $storageRepository
     */
    public function __construct(UrlClientFacade $urlClientFacade, CacheRepository $storageRepository)
    {
        $this->urlClientFacade = $urlClientFacade;
        $this->storageRepository = $storageRepository;
    }

    /**
     * @param Bin $bin
     * @return string
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function getAlpha2(Bin $bin): string
    {
        if ($this->storageRepository->isKeyExists($bin->getValue())) {
            $alpha2 = $this->storageRepository->getFromStorage($bin->getValue());
        } else {
            $alpha2 = $this->getAlpha2FromSource($bin);
            $this->storageRepository->setToStorage($bin->getValue(), $alpha2);
        }

        return $alpha2;
    }

    /**
     * @param Bin $bin
     * @return string
     * @throws NotFoundException
     * @throws UrlClientException
     */
    private function getAlpha2FromSource(Bin $bin): string
    {
        $data = $this->urlClientFacade->executeGetRequest(self::URL . $bin->getValue());
        $obj = json_decode($data);

        if (!isset($obj->country->alpha2) || empty($obj->country->alpha2)) {
            throw new NotFoundException('Alpha2 is not found');
        }

        return $obj->country->alpha2;
    }
}
