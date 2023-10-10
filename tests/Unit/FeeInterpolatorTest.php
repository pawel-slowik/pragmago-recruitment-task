<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Unit;

use Brick\Money\Money;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\FeeInterpolator;
use PragmaGoTech\Interview\Model\FeeBreakpoint;
use PragmaGoTech\Interview\Model\LoanProposal;

/**
 * @covers \PragmaGoTech\Interview\FeeInterpolator
 */
class FeeInterpolatorTest extends TestCase
{
    private FeeInterpolator $feeInterpolator;

    protected function setUp(): void
    {
        $this->feeInterpolator = new FeeInterpolator();
    }

    /**
     * @dataProvider interpolationDataProvider
     *
     * @param FeeBreakpoint[] $breakpoints
     */
    public function testInterpolation(array $breakpoints, Money $amount, Money $expectedValue): void
    {
        $proposal = $this->createStub(LoanProposal::class);
        $proposal->method('term')->willReturn(24);
        $proposal->method('amount')->willReturn($amount);

        $value = $this->feeInterpolator->interpolate($proposal, ...$breakpoints);

        $this->assertTrue($value->isEqualTo($expectedValue));
    }

    /**
     * @return array<array{0: array<FeeBreakpoint>, 1: Money, 2: Money}>
     */
    public function interpolationDataProvider(): array
    {
        // phpcs:disable PEAR.Functions.FunctionCallSignature.SpaceAfterOpenBracket
        // phpcs:disable PSR2.Methods.FunctionCallSignature.SpaceAfterOpenBracket
        $breakpoints = [
            new FeeBreakpoint(Money::of('500.00', 'PLN'), Money::of('11.00', 'PLN')),
            new FeeBreakpoint(Money::of('300.00', 'PLN'), Money::of( '7.00', 'PLN')),
            new FeeBreakpoint(Money::of('200.00', 'PLN'), Money::of( '4.50', 'PLN')),
            new FeeBreakpoint(Money::of('100.00', 'PLN'), Money::of( '3.00', 'PLN')),
        ];
        // phpcs:enable

        return [
            [$breakpoints, Money::of('100.00', 'PLN'), Money::of('3.00', 'PLN')],
            [$breakpoints, Money::of('500.00', 'PLN'), Money::of('11.00', 'PLN')],
            [$breakpoints, Money::of('400.00', 'PLN'), Money::of('9.00', 'PLN')],
            [$breakpoints, Money::of('433.00', 'PLN'), Money::of('9.66', 'PLN')],
        ];
    }
}
