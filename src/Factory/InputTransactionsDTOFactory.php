<?php

namespace Task\Factory;

use Money\Currency;
use Money\Money;
use Task\DTO\InputTransactionsDTO;
use Task\ValueObject\Bin;
use Task\Exception\EmptyArgumentException;
use Task\Exception\NotStringArgumentException;

class InputTransactionsDTOFactory
{
    /**
     * @param array $data
     * @return InputTransactionsDTO
     * @throws EmptyArgumentException
     * @throws NotStringArgumentException
     */
    public function createFromArray(array $data): InputTransactionsDTO
    {
        return new InputTransactionsDTO(
            new Bin($data['bin']),
            new Money($data['amount'], new Currency($data['currency']))
        );
    }
}
