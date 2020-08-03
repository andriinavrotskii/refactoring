<?php

namespace Task\Repository;

use Task\DTO\BinListDTO;
use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\Facade\UrlClientFacade;
use Task\Factory\BinListDTOFactory;

class BinListRepository
{
    private const URL = 'https://lookup.binlist.net/';

    /**
     * @var UrlClientFacade
     */
    private $urlClientFacade;

    /**
     * @var BinListDTOFactory
     */
    private $binListDTOFactory;

    /**
     * BinListRepository constructor.
     * @param UrlClientFacade $urlClientFacade
     * @param BinListDTOFactory $binListDTOFactory
     */
    public function __construct(
        UrlClientFacade $urlClientFacade,
        BinListDTOFactory $binListDTOFactory
    ) {
        $this->urlClientFacade = $urlClientFacade;
        $this->binListDTOFactory = $binListDTOFactory;
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
