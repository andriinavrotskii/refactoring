<?php

namespace Task\DTO;

use Money\Money;
use Task\ValueObject\Bin;

class InputTransactionsDTO
{
    /**
     * @var Bin
     */
    private $bin;

    /**
     * @var Money
     */
    private $money;

    /**
     * InputTransactionsDTO constructor.
     *
     * @param Bin   $bin
     * @param Money $money
     */
    public function __construct(
        Bin $bin,
        Money $money
    ) {
        $this->bin = $bin;
        $this->money = $money;
    }

    /**
     * @return Bin
     */
    public function getBin(): Bin
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
