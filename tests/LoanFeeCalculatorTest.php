<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\LoanFeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;

/**
 * @covers \PragmaGoTech\Interview\LoanFeeCalculator
 */
class LoanFeeCalculatorTest extends TestCase
{
    private LoanFeeCalculator $loanFeeCalculator;

    protected function setUp(): void
    {
        $this->loanFeeCalculator = new LoanFeeCalculator();
    }

    /**
     * @dataProvider calculatedFeeDataProvider
     */
    public function testCalculatedFee(int $term, float $amount, float $expectedFee): void
    {
        $proposal = $this->createStub(LoanProposal::class);
        $proposal->method('term')->willReturn($term);
        $proposal->method('amount')->willReturn($amount);

        $calculatedFee = $this->loanFeeCalculator->calculate($proposal);

        $this->assertSame($expectedFee, $calculatedFee);
    }

    /**
     * @return array<array{0: int, 1: float, 2: float}>
     */
    public function calculatedFeeDataProvider(): array
    {
        return [
            [24, 11500.00, 460.00],
            [12, 19250.00, 385.00],
            [24,  2750.00, 115.00],
            [12,  1000.00,  50.00],
            [12,  2000.00,  90.00],
            [12,  3000.00,  90.00],
            [12,  4000.00, 115.00],
            [12,  5000.00, 100.00],
            [12,  6000.00, 120.00],
            [12,  7000.00, 140.00],
            [12,  8000.00, 160.00],
            [12,  9000.00, 180.00],
            [12, 10000.00, 200.00],
            [12, 11000.00, 220.00],
            [12, 12000.00, 240.00],
            [12, 13000.00, 260.00],
            [12, 14000.00, 280.00],
            [12, 15000.00, 300.00],
            [12, 16000.00, 320.00],
            [12, 17000.00, 340.00],
            [12, 18000.00, 360.00],
            [12, 19000.00, 380.00],
            [12, 20000.00, 400.00],
            [24,  1000.00,  70.00],
            [24,  2000.00, 100.00],
            [24,  3000.00, 120.00],
            [24,  4000.00, 160.00],
            [24,  5000.00, 200.00],
            [24,  6000.00, 240.00],
            [24,  7000.00, 280.00],
            [24,  8000.00, 320.00],
            [24,  9000.00, 360.00],
            [24, 10000.00, 400.00],
            [24, 11000.00, 440.00],
            [24, 12000.00, 480.00],
            [24, 13000.00, 520.00],
            [24, 14000.00, 560.00],
            [24, 15000.00, 600.00],
            [24, 16000.00, 640.00],
            [24, 17000.00, 680.00],
            [24, 18000.00, 720.00],
            [24, 19000.00, 760.00],
            [24, 20000.00, 800.00],
        ];
    }
}
