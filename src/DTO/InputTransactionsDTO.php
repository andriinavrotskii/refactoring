<?php

namespace Task\DTO;

use Money\Money;

class InputTransactionsDTO
{
    /**
     * @var int
     */
    private $bin;

    /**
     * @var Money
     */
    private $money;

    /**
     * InputTransactionsDTO constructor.
     *
     * @param int   $bin
     * @param Money $money
     */
    public function __construct(
        int $bin,
        Money $money
    ) {
        $this->bin = $bin;
        $this->money = $money;
    }

    /**
     * @return int
     */
    public function getBin(): int
    {
        return $this->bin;
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }
}
