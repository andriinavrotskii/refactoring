<?php

namespace Task\Repository;

use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\Facade\UrlClientFacade;
use Task\ValueObject\Bin;

class BinListRepository
{
    private const URL = 'https://lookup.binlist.net/';

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

    /**
     * @param Bin $bin
     * @return string
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function getAlpha2(Bin $bin): string
    {
        $data = $this->urlClientFacade->executeGetRequest(self::URL . $bin->getValue());
        $obj = json_decode($data);

        if (!isset($obj->country->alpha2) || empty($obj->country->alpha2)) {
            throw new NotFoundException('Alpha2 is not found');
        }

        return $obj->country->alpha2;
    }
}
