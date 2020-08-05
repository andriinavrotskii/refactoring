<?php

declare(strict_types=1);

namespace Task\Service\File;

use Psr\Log\LoggerInterface;
use Task\DTO\InputTransactionsDTO;
use Task\Factory\InputTransactionsDTOFactory;
use \Traversable;

class ReaderService
{
    /**
     * @var InputTransactionsDTOFactory
     */
    private $inputTransactionsDTOFactory;
    /**
     * @var LoggerInterface
     */
    private $log;

    /**
     * ReaderService constructor.
     * @param InputTransactionsDTOFactory $inputTransactionsDTOFactory
     * @param LoggerInterface $log
     */
    public function __construct(
        InputTransactionsDTOFactory $inputTransactionsDTOFactory,
        LoggerInterface $log
    ) {
        $this->inputTransactionsDTOFactory = $inputTransactionsDTOFactory;
        $this->log = $log;
    }

    /**
     * @param string $fileWithData
     *
     * @return Traversable|InputTransactionsDTO
     */
    public function readTransactionCommission(string $fileWithData): Traversable
    {
        foreach (explode("\n", file_get_contents($fileWithData)) as $row) {
            if (empty($row)) {
                continue;
            }

            try {
                yield $this->inputTransactionsDTOFactory->createFromArray(
                    json_decode($row, true)
                );
            } catch (\Exception $exception) {
                $this->log->error($exception->getMessage(), $exception->getTrace());
            }
        }
    }
}
