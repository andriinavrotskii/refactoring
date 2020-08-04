<?php

namespace Task\Service;

use Money\Money;
use Task\DTO\InputTransactionsDTO;
use Task\Enum\CounryCodeEnum;
use Task\Repository\BinListRepository;
use Task\Repository\ExchangeRateRepository;

class TransactionCommissionService
{
    private const COEFFICIENT_EU = 0.01;
    private const COEFFICIENT_NON_EU = 0.02;

    /**
     * @var BinListRepository
     */
    private $binlistRepository;

    /**
     * @var ExchangeRateRepository
     */
    private $exchangeRateRepository;

    public function __construct(
        BinListRepository $binlistRepository,
        ExchangeRateRepository  $exchangeRateRepository
    ) {

        $this->binlistRepository = $binlistRepository;
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    /**
     * @param InputTransactionsDTO $dto
     * @return float
     * @throws \Task\Exception\NotFoundException
     * @throws \Task\Exception\UrlClientException
     */
    public function process(InputTransactionsDTO $dto): float
    {
        $rate = $this->exchangeRateRepository->getRate($dto->getMoney()->getCurrency());
        $isEu = $this->isEu($dto);

        $resultAmount = $dto->getMoney()->getAmount() / $rate;

        if (true === $isEu) {
            $resultAmount = $resultAmount * self::COEFFICIENT_EU;
        } else {
            $resultAmount = $resultAmount * self::COEFFICIENT_NON_EU;
        }

        return $resultAmount;
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