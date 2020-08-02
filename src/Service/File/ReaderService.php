<?php

namespace Task\Service\File;

use Task\DTO\InputTransactionsDTO;
use Task\Factory\InputTransactionsDTOFactory;

class ReaderService
{
    /**
     * @var InputTransactionsDTOFactory
     */
    private $inputTransactionsDTOFactory;

    public function __construct(InputTransactionsDTOFactory $inputTransactionsDTOFactory)
    {
        $this->inputTransactionsDTOFactory = $inputTransactionsDTOFactory;
    }

    /**
     * @param string $fileWithData
     *
     * @return \Traversable|InputTransactionsDTO
     */
    public function readTransactionCommission(string $fileWithData): \Traversable
    {
        foreach (explode("\n", file_get_contents($fileWithData)) as $row) {
            if (empty($row)) {
                continue;
            }

            yield $this->inputTransactionsDTOFactory->createFromArray(
                json_decode($row, true)
            );
        }
    }
}
