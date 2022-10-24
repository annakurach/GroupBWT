<?php

namespace tests;

use BinProvider;
use CommissionCalculator;
use Exception;
use PHPUnit\Framework\TestCase;
use RatesProvider;

class CalculateTest extends TestCase
{

    public BinProvider $binProvider;
    public RatesProvider $ratesProvider;
    public CommissionCalculator $commissionCalculator;

    protected function setUp(): void
    {
        $this->binProvider = $this->createMock(BinProvider::class);
        $this->ratesProvider = $this->createMock(RatesProvider::class);
        $this->commissionCalculator = new CommissionCalculator($this->binProvider, $this->ratesProvider);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCalculateSuccessEur(): void
    {
        $currency = 'EUR';
        $amount = 1000;
        $this->binProvider
            ->expects($this->once())
            ->method('getBinValue')
            ->willReturn('GR');

        $this->ratesProvider
            ->expects($this->once())
            ->method('getRatesValue')
            ->willReturn(3.2);

        $result = $this->commissionCalculator->calculate($amount, $currency);
        $this->assertIsFloat($result);
        $this->assertNotEquals(0.0, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCalculateSuccessNotEur(): void
    {
        $currency = 'USD';
        $amount = 1000;
        $this->binProvider
            ->expects($this->once())
            ->method('getBinValue')
            ->willReturn('GR');

        $this->ratesProvider
            ->expects($this->once())
            ->method('getRatesValue')
            ->willReturn(1.4);

        $result = $this->commissionCalculator->calculate($amount, $currency);
        $this->assertIsFloat($result);
        $this->assertNotEquals(0.0, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCalculateFailsInvalidRates(): void
    {
        $currency = 'EUR';
        $amount = 1000;
        $this->binProvider
            ->expects($this->once())
            ->method('getBinValue')
            ->willReturn('GR');

        $this->ratesProvider
            ->expects($this->once())
            ->method('getRatesValue')
            ->willReturn(-3);
        $this->expectException(Exception::class);
        $this->commissionCalculator->calculate($amount, $currency);
    }
}
