<?php

declare(strict_types=1);

namespace Task\Repository;

use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\Facade\UrlClientFacade;
use Task\ValueObject\Alpha2;
use Task\ValueObject\Bin;

class BinListRepository implements BinListRepositoryInterface
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
     * @return Alpha2
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function getAlpha2(Bin $bin): Alpha2
    {
        $data = $this->urlClientFacade->executeGetRequest(self::URL . $bin->getValue());
        $obj = json_decode($data);

        if (!isset($obj->country->alpha2) || empty($obj->country->alpha2)) {
            throw new NotFoundException('Alpha2 is not found');
        }

        return new Alpha2($obj->country->alpha2);
    }
}
