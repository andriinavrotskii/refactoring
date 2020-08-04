<?php

namespace Task\Service;

use Money\Money;
use Task\DTO\InputTransactionsDTO;
use Task\Enum\CounryCodeEnum;
use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\Repository\BinListRepository;
use Task\Repository\BinListRepositoryInterface;
use Task\Repository\ExchangeRateRepository;
use Task\Repository\ExchangeRateRepositoryInterface;
use Task\ValueObject\Bin;

class TransactionCommissionService
{
    private const COEFFICIENT_EU = 0.01;
    private const COEFFICIENT_NON_EU = 0.02;

    /**
     * @var BinListRepositoryInterface
     */
    private $binlistRepository;

    /**
     * @var ExchangeRateRepositoryInterface
     */
    private $exchangeRateRepository;

    public function __construct(
        BinListRepositoryInterface $binlistRepository,
        ExchangeRateRepositoryInterface $exchangeRateRepository
    ) {

        $this->binlistRepository = $binlistRepository;
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    /**
     * @param InputTransactionsDTO $dto
     * @return float
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function process(InputTransactionsDTO $dto): float
    {
        $rate = $this->exchangeRateRepository->getRate($dto->getMoney()->getCurrency());
        $resultAmount = $dto->getMoney()->getAmount() / $rate;

        if ($this->isEu($dto->getBin())) {
            $resultAmount = $resultAmount * self::COEFFICIENT_EU;
        } else {
            $resultAmount = $resultAmount * self::COEFFICIENT_NON_EU;
        }

        return $resultAmount;
    }

    /**
     * @param Bin $bin
     * @return bool
     * @throws NotFoundException
     * @throws UrlClientException
     */
    public function isEu(Bin $bin): bool
    {
        $alpha2 = $this->binlistRepository->getAlpha2($bin);

        return CounryCodeEnum::hasValue($alpha2->getValue());
    }
}