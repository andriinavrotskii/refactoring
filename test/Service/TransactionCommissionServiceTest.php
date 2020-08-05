<?php

use PHPUnit\Framework\TestCase;
use Task\DTO\InputTransactionsDTO;
use Task\Exception\NotFoundException;
use Task\Repository\BinListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Task\Repository\ExchangeRateRepositoryInterface;
use Task\Service\TransactionCommissionService;
use Money\Currency;
use Money\Money;
use Task\ValueObject\Rate;
use Task\ValueObject\Bin;
use Task\ValueObject\Alpha2;
use Task\Exception\TransactionCommissionServiceException;

class TransactionCommissionServiceTest extends TestCase
{
    /**
     * @var MockObject|BinListRepositoryInterface
     */
    private $binListRepositoryMock;

    /**
     * @var MockObject|ExchangeRateRepositoryInterface
     */
    private $exchangeRateRepositoryMock;

    /**
     * @var TransactionCommissionService
     */
    private $transactionCommissionService;

    public function setUp(): void
    {
        $this->binListRepositoryMock = $this->createMock(BinListRepositoryInterface::class);
        $this->exchangeRateRepositoryMock = $this->createMock(ExchangeRateRepositoryInterface::class);
        $this->transactionCommissionService = new TransactionCommissionService(
            $this->binListRepositoryMock,
            $this->exchangeRateRepositoryMock
        );
    }

    public function tearDown(): void
    {
        unset(
            $this->binListRepositoryMock,
            $this->exchangeRateRepositoryMock,
            $this->transactionCommissionService
        );
    }

    /**
     * @param InputTransactionsDTO $dto
     * @param Currency $currency
     * @param Rate $rate
     * @param Bin $bin
     * @param Alpha2 $alpha2
     * @param float $expectedResult
     * @param string|null $expectedException
     * @dataProvider dataProvider
     */
    public function testProcess(
        InputTransactionsDTO $dto,
        Currency $currency,
        Rate $rate,
        Bin $bin,
        Alpha2 $alpha2,
        float $expectedResult,
        ?string $getAlpha2willThrowException,
        ?string $expectedException
    ) {
        if (null !== $expectedException) {
            $this->expectException($expectedException);
        }

        $this->exchangeRateRepositoryMock->expects($this->once())
            ->method('getRate')
            ->with($currency)
            ->willReturn($rate);

        $this->binListRepositoryMock->expects($this->once())
            ->method('getAlpha2')
            ->with($bin)
            ->willReturnCallback(function () use ($alpha2, $getAlpha2willThrowException) {
                if (null === $getAlpha2willThrowException) {
                    return $alpha2;
                }

                throw new $getAlpha2willThrowException;
            });
        $this->assertEquals(
            $expectedResult,
            $this->transactionCommissionService->process($dto)
        );
    }

    /**
     * @return Traversable
     */
    public function dataProvider(): \Traversable
    {
        $dto = new InputTransactionsDTO(
            new Bin(45717360),
            new Money(100.00, new Currency('EUR'))
        );

        $default = [
            'dto' => $dto,
            'currency' => $dto->getMoney()->getCurrency(),
            'rate' => new Rate(1.0),
            'bin' => $dto->getBin(),
            'alpha2' => new Alpha2('AT'),
            'expectedResult' => 1,
            'getAlpha2willThrowException' => null,
            'expectedException' => null,
        ];
        yield 'default' => $default;

        yield 'not_eu' => array_merge($default, [
            'alpha2' => new Alpha2('NOT_EU'),
            'expectedResult' => 2,
        ]);

        yield 'exeption' => array_merge($default, [
            'getAlpha2willThrowException' => NotFoundException::class,
            'expectedException' => TransactionCommissionServiceException::class,
        ]);
    }
}