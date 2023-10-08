<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Unit;

use Brick\Money\Money;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\FeeRoundingDecorator;
use PragmaGoTech\Interview\Model\LoanProposal;

/**
 * @covers \PragmaGoTech\Interview\FeeRoundingDecorator
 */
class FeeRoundingDecoratorTest extends TestCase
{
    private FeeRoundingDecorator $feeRoundingDecorator;

    /** @var FeeCalculator&Stub */
    private FeeCalculator $feeCalculator;

    protected function setUp(): void
    {
        $this->feeCalculator = $this->createStub(FeeCalculator::class);
        $this->feeRoundingDecorator = new FeeRoundingDecorator($this->feeCalculator);
    }

    /**
     * @dataProvider calculatedFeeDataProvider
     */
    public function testCalculatedFee(
        Money $amount,
        Money $originalFee,
        Money $expectedRoundedFee
    ): void {
        $proposal = $this->createStub(LoanProposal::class);
        $proposal->method('amount')->willReturn($amount);
        $this->feeCalculator->method('calculate')->willReturn($originalFee);

        $calculatedFee = $this->feeRoundingDecorator->calculate($proposal);

        $this->assertTrue($calculatedFee->isEqualTo($expectedRoundedFee));
    }

    /**
     * @return array<array{0: Money, 1: Money, 2: Money}>
     */
    public function calculatedFeeDataProvider(): array
    {
        return [
            [Money::of('20.00', 'PLN'), Money::of('10.00', 'PLN'), Money::of('10.00', 'PLN')],
            [Money::of('20.00', 'PLN'), Money::of('15.00', 'PLN'), Money::of('15.00', 'PLN')],
            [Money::of('41.00', 'PLN'), Money::of('22.00', 'PLN'), Money::of('24.00', 'PLN')],
            [Money::of('51.33', 'PLN'), Money::of('12.01', 'PLN'), Money::of('13.67', 'PLN')],
        ];
    }
}
