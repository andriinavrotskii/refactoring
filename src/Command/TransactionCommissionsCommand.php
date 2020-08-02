<?php

namespace Task\Command;

use Task\Service\File\ReaderService;
use Task\Service\TransactionCommissionService;

class TransactionCommissionsCommand
{
    /**
     * @var ReaderService
     */
    private $readerService;

    /**
     * @var TransactionCommissionService
     */
    private $transactionCommissionService;

    public function __construct(
        ReaderService $readerService,
        TransactionCommissionService $transactionCommissionService
    ) {
        $this->readerService = $readerService;
        $this->transactionCommissionService = $transactionCommissionService;
    }

    public function run(string $fileWithInputData): void
    {
        var_dump($fileWithInputData);
        foreach (
            $this->readerService->readTransactionCommission($fileWithInputData)
            as $dto
        ) {
            $this->transactionCommissionService->process($dto);
        }
    }
}
