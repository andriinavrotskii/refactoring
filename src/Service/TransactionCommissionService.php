<?php

namespace Task\Service;

use Task\DTO\InputTransactionsDTO;
use Task\Enum\CounryCodeEnum;
use Task\Exception\NotFoundException;
use Task\Exception\TransactionCommissionServiceException;
use Task\Exception\UrlClientException;
use Task\Repository\BinListRepositoryInterface;
use Task\Repository\ExchangeRateRepositoryInterface;
use Task\ValueObject\Bin;

class TransactionCommissionService
{
    private const COEFFICIENT_EU = 0.01;
    private const COEFFICIENT_NON_EU = 0.02;

    /**
     * @var BinListRepositoryInterface
     */
    private $binListRepository;

    /**
     * @var ExchangeRateRepositoryInterface
     */
    private $exchangeRateRepository;

    /**
     * TransactionCommissionService constructor.
     * @param BinListRepositoryInterface $binListRepository
     * @param ExchangeRateRepositoryInterface $exchangeRateRepository
     */
    public function __construct(
        BinListRepositoryInterface $binListRepository,
        ExchangeRateRepositoryInterface $exchangeRateRepository
    ) {

        $this->binListRepository = $binListRepository;
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    /**
     * @param InputTransactionsDTO $dto
     * @return float
     * @throws TransactionCommissionServiceException
     */
    public function process(InputTransactionsDTO $dto): float
    {
        try {
            $rate = $this->exchangeRateRepository->getRate($dto->getMoney()->getCurrency());
            $resultAmount = $dto->getMoney()->getAmount() / $rate->getValue();

            if ($this->isEu($dto->getBin())) {
                $resultAmount = $resultAmount * self::COEFFICIENT_EU;
            } else {
                $resultAmount = $resultAmount * self::COEFFICIENT_NON_EU;
            }

            return $resultAmount;
        } catch (\Throwable $exception) {
            throw new TransactionCommissionServiceException(
                'TransactionCommissionService failed. Reason: ' . $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * @param Bin $bin
     * @return bool
     * @throws NotFoundException
     * @throws UrlClientException
     */
    private function isEu(Bin $bin): bool
    {
        $alpha2 = $this->binListRepository->getAlpha2($bin);

        return CounryCodeEnum::hasValue($alpha2->getValue());
    }
}
