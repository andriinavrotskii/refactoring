<?php

namespace Task\Service;

use Task\DTO\InputTransactionsDTO;

class TransactionCommissionService
{
    /**
     * @param InputTransactionsDTO $dto
     */
    public function process(InputTransactionsDTO $dto): void
    {
        var_dump($dto);
    }
}