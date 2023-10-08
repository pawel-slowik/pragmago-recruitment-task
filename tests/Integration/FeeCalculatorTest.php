<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Integration;

use Brick\Money\Money;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\FeeRoundingDecorator;
use PragmaGoTech\Interview\LoanFeeBreakpointRepository;
use PragmaGoTech\Interview\LoanFeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;

/**
 * @covers \PragmaGoTech\Interview\LoanFeeCalculator
 * @covers \PragmaGoTech\Interview\FeeRoundingDecorator
 */
class FeeCalculatorTest extends TestCase
{
    private FeeCalculator $feeCalculator;

    protected function setUp(): void
    {
        $this->feeCalculator = new FeeRoundingDecorator(
            new LoanFeeCalculator(
                new LoanFeeBreakpointRepository(),
            )
        );
    }

    /**
     * @dataProvider calculatedFeeDataProvider
     */
    public function testCalculatedFee(int $term, Money $amount, Money $expectedFee): void
    {
        $proposal = $this->createStub(LoanProposal::class);
        $proposal->method('term')->willReturn($term);
        $proposal->method('amount')->willReturn($amount);

        $calculatedFee = $this->feeCalculator->calculate($proposal);

        $this->assertTrue($calculatedFee->isEqualTo($expectedFee));
    }

    /**
     * @return array<array{0: int, 1: Money, 2: Money}>
     */
    public function calculatedFeeDataProvider(): array
    {
        // phpcs:disable PEAR.Functions.FunctionCallSignature.SpaceAfterOpenBracket
        // phpcs:disable PSR2.Methods.FunctionCallSignature.SpaceAfterOpenBracket
        return [
            [24, Money::of('11500.00', 'PLN'), Money::of('460.00', 'PLN')],
            [12, Money::of('19250.00', 'PLN'), Money::of('385.00', 'PLN')],
            [24, Money::of( '2750.00', 'PLN'), Money::of('115.00', 'PLN')],
            [12, Money::of( '1000.00', 'PLN'), Money::of( '50.00', 'PLN')],
            [12, Money::of( '2000.00', 'PLN'), Money::of( '90.00', 'PLN')],
            [12, Money::of( '3000.00', 'PLN'), Money::of( '90.00', 'PLN')],
            [12, Money::of( '4000.00', 'PLN'), Money::of('115.00', 'PLN')],
            [12, Money::of( '5000.00', 'PLN'), Money::of('100.00', 'PLN')],
            [12, Money::of( '6000.00', 'PLN'), Money::of('120.00', 'PLN')],
            [12, Money::of( '7000.00', 'PLN'), Money::of('140.00', 'PLN')],
            [12, Money::of( '8000.00', 'PLN'), Money::of('160.00', 'PLN')],
            [12, Money::of( '9000.00', 'PLN'), Money::of('180.00', 'PLN')],
            [12, Money::of('10000.00', 'PLN'), Money::of('200.00', 'PLN')],
            [12, Money::of('11000.00', 'PLN'), Money::of('220.00', 'PLN')],
            [12, Money::of('12000.00', 'PLN'), Money::of('240.00', 'PLN')],
            [12, Money::of('13000.00', 'PLN'), Money::of('260.00', 'PLN')],
            [12, Money::of('14000.00', 'PLN'), Money::of('280.00', 'PLN')],
            [12, Money::of('15000.00', 'PLN'), Money::of('300.00', 'PLN')],
            [12, Money::of('16000.00', 'PLN'), Money::of('320.00', 'PLN')],
            [12, Money::of('17000.00', 'PLN'), Money::of('340.00', 'PLN')],
            [12, Money::of('18000.00', 'PLN'), Money::of('360.00', 'PLN')],
            [12, Money::of('19000.00', 'PLN'), Money::of('380.00', 'PLN')],
            [12, Money::of('20000.00', 'PLN'), Money::of('400.00', 'PLN')],
            [24, Money::of( '1000.00', 'PLN'), Money::of( '70.00', 'PLN')],
            [24, Money::of( '1001.00', 'PLN'), Money::of( '74.00', 'PLN')],
            [24, Money::of( '1001.50', 'PLN'), Money::of( '73.50', 'PLN')],
            [24, Money::of( '1001.51', 'PLN'), Money::of( '73.49', 'PLN')],
            [24, Money::of( '2000.00', 'PLN'), Money::of('100.00', 'PLN')],
            [24, Money::of( '3000.00', 'PLN'), Money::of('120.00', 'PLN')],
            [24, Money::of( '4000.00', 'PLN'), Money::of('160.00', 'PLN')],
            [24, Money::of( '5000.00', 'PLN'), Money::of('200.00', 'PLN')],
            [24, Money::of( '6000.00', 'PLN'), Money::of('240.00', 'PLN')],
            [24, Money::of( '7000.00', 'PLN'), Money::of('280.00', 'PLN')],
            [24, Money::of( '8000.00', 'PLN'), Money::of('320.00', 'PLN')],
            [24, Money::of( '9000.00', 'PLN'), Money::of('360.00', 'PLN')],
            [24, Money::of('10000.00', 'PLN'), Money::of('400.00', 'PLN')],
            [24, Money::of('11000.00', 'PLN'), Money::of('440.00', 'PLN')],
            [24, Money::of('12000.00', 'PLN'), Money::of('480.00', 'PLN')],
            [24, Money::of('13000.00', 'PLN'), Money::of('520.00', 'PLN')],
            [24, Money::of('14000.00', 'PLN'), Money::of('560.00', 'PLN')],
            [24, Money::of('15000.00', 'PLN'), Money::of('600.00', 'PLN')],
            [24, Money::of('16000.00', 'PLN'), Money::of('640.00', 'PLN')],
            [24, Money::of('17000.00', 'PLN'), Money::of('680.00', 'PLN')],
            [24, Money::of('18000.00', 'PLN'), Money::of('720.00', 'PLN')],
            [24, Money::of('19000.00', 'PLN'), Money::of('760.00', 'PLN')],
            [24, Money::of('20000.00', 'PLN'), Money::of('800.00', 'PLN')],
        ];
        // phpcs:enable
    }
}
