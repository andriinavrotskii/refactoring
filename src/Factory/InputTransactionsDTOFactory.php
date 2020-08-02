<?php

namespace Task\Factory;

use Money\Currency;
use Money\Money;
use Task\DTO\InputTransactionsDTO;

class InputTransactionsDTOFactory
{
    /**
     * @param array $data
     *
     * @return InputTransactionsDTO
     */
    public function createFromArray(array $data): InputTransactionsDTO
    {
        return new InputTransactionsDTO(
            (int)$data['bin'],
            new Money($data['amount'], new Currency($data['currency']))
        );
    }
}
