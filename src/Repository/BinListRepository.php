<?php

namespace Task\Repository;

use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\Facade\UrlClientFacade;

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
     * @param $param
     * @return string
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function getAlpha2($param): string
    {
        $data = $this->urlClientFacade->executeGetRequest(self::URL . $param );
        $obj = json_decode($data);

        if (!isset($obj->country->alpha2) || empty($obj->country->alpha2)) {
            throw new NotFoundException('Alpha2 is not found');
        }

        return $obj->country->alpha2;
    }
}
