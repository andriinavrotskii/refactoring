<?php

declare(strict_types=1);

namespace Task\Factory;

use Money\Currency;
use Money\Money;
use Task\DTO\InputTransactionsDTO;
use Task\Exception\OutOfBondException;
use Task\ValueObject\Bin;
use Task\Exception\EmptyArgumentException;
use Task\Exception\NotFloatArgumentException;

class InputTransactionsDTOFactory
{
    /**
     * @param array $data
     * @return InputTransactionsDTO
     * @throws EmptyArgumentException
     * @throws NotFloatArgumentException
     * @throws OutOfBondException
     */
    public function createFromArray(array $data): InputTransactionsDTO
    {
        $this->validation($data);

        return new InputTransactionsDTO(
            new Bin((int) $data['bin']),
            new Money($data['amount'], new Currency($data['currency']))
        );
    }

    /**
     * @param array $data
     * @throws OutOfBondException
     */
    public function validation(array $data): void
    {
        $problematicParameters = [];
        if (false === array_key_exists('bin', $data)) {
            $problematicParameters[] = 'bin';
        }
        if (false === array_key_exists('amount', $data)) {
            $problematicParameters[] = 'amount';
        }
        if (false === array_key_exists('currency', $data)) {
            $problematicParameters[] = 'currency';
        }

        if (false === empty($problematicParameters)) {
            throw new OutOfBondException(implode(', ', $problematicParameters));
        }
    }
}
