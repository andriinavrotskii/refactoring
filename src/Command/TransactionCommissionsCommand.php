<?php

namespace Task\Command;

use Task\Service\TransactionCommissionService;

class TransactionCommissionsCommand
{
    /**
     * @var TransactionCommissionService
     */
    private $transactionCommissionService;

    /**
     * TransactionCommissionsCommand constructor.
     *
     * @param TransactionCommissionService $transactionCommissionService
     */
    public function __construct(TransactionCommissionService $transactionCommissionService)
    {
        $this->transactionCommissionService = $transactionCommissionService;
    }

    public function run(): void
    {
        var_dump('run');
        $this->transactionCommissionService->hello();
    }
}
