<?php

declare(strict_types=1);

namespace Task\Command;

use Psr\Log\LoggerInterface;
use Task\Log\InlineLog;
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

    /**
     * @var LoggerInterface
     */
    private $log;

    /**
     * TransactionCommissionsCommand constructor.
     * @param ReaderService $readerService
     * @param TransactionCommissionService $transactionCommissionService
     * @param InlineLog $log
     */
    public function __construct(
        ReaderService $readerService,
        TransactionCommissionService $transactionCommissionService,
        InlineLog $log
    ) {
        $this->readerService = $readerService;
        $this->transactionCommissionService = $transactionCommissionService;
        $this->log = $log;
    }

    /**
     * @param string $fileWithInputData
     */
    public function run(string $fileWithInputData): void
    {
        foreach ($this->readerService->readTransactionCommission($fileWithInputData) as $dto) {
            try {
                $result = $this->transactionCommissionService->process($dto);
                $this->log->info($result);
            } catch (\Throwable $exception) {
                $this->log->error($exception->getMessage());
            }
        }
    }
}
