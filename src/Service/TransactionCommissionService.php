<?php

namespace Task\Service;

use Task\DTO\InputTransactionsDTO;
use Task\Enum\CounryCodeEnum;
use Task\Repository\BinListRepository;

class TransactionCommissionService
{
    /**
     * @var BinListRepository
     */
    private $binlistRepository;

    public function __construct(
        BinListRepository $binlistRepository
    ) {

        $this->binlistRepository = $binlistRepository;
    }

    /**
     * @param InputTransactionsDTO $dto
     */
    public function process(InputTransactionsDTO $dto): void
    {
        $isEu = $this->isEu($dto);
//        var_dump($dto);
    }

    /**
     * @param InputTransactionsDTO $dto
     * @return bool
     * @throws \Task\Exception\NotFoundException
     * @throws \Task\Exception\UrlClientException
     */
    public function isEu(InputTransactionsDTO $dto): bool
    {
        $alpha2 = $this->binlistRepository->getAlpha2($dto->getBin());

        return CounryCodeEnum::hasValue($alpha2);
    }
}