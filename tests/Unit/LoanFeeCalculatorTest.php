<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Unit;

use Brick\Money\Money;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\LoanFeeBreakpointRepository;
use PragmaGoTech\Interview\LoanFeeCalculator;
use PragmaGoTech\Interview\Model\LoanFeeBreakpoint;
use PragmaGoTech\Interview\Model\LoanProposal;

/**
 * @covers \PragmaGoTech\Interview\LoanFeeCalculator
 */
class LoanFeeCalculatorTest extends TestCase
{
    private LoanFeeCalculator $loanFeeCalculator;

    /** @var LoanFeeBreakpointRepository&Stub */
    private LoanFeeBreakpointRepository $loanFeeBreakpointRepository;

    protected function setUp(): void
    {
        $this->loanFeeBreakpointRepository = $this->createStub(LoanFeeBreakpointRepository::class);
        $this->loanFeeCalculator = new LoanFeeCalculator(
            $this->loanFeeBreakpointRepository,
        );
    }

    /**
     * @dataProvider calculatedFeeDataProvider
     */
    public function testCalculatedFee(int $term, Money $amount, Money $expectedFee): void
    {
        // phpcs:disable PEAR.Functions.FunctionCallSignature.SpaceAfterOpenBracket
        // phpcs:disable PSR2.Methods.FunctionCallSignature.SpaceAfterOpenBracket
        $this->loanFeeBreakpointRepository
            ->method('listAll')
            ->willReturn(
                [
                    new LoanFeeBreakpoint(12, Money::of('100.00', 'PLN'), Money::of( '2.00', 'PLN')),
                    new LoanFeeBreakpoint(12, Money::of('200.00', 'PLN'), Money::of( '3.00', 'PLN')),
                    new LoanFeeBreakpoint(12, Money::of('300.00', 'PLN'), Money::of( '5.00', 'PLN')),
                    new LoanFeeBreakpoint(12, Money::of('500.00', 'PLN'), Money::of( '9.00', 'PLN')),
                    new LoanFeeBreakpoint(24, Money::of('500.00', 'PLN'), Money::of('11.00', 'PLN')),
                    new LoanFeeBreakpoint(24, Money::of('300.00', 'PLN'), Money::of( '7.00', 'PLN')),
                    new LoanFeeBreakpoint(24, Money::of('200.00', 'PLN'), Money::of( '4.50', 'PLN')),
                    new LoanFeeBreakpoint(24, Money::of('100.00', 'PLN'), Money::of( '3.00', 'PLN')),
                ]
            );
        // phpcs:enable

        $proposal = $this->createStub(LoanProposal::class);
        $proposal->method('term')->willReturn($term);
        $proposal->method('amount')->willReturn($amount);

        $calculatedFee = $this->loanFeeCalculator->calculate($proposal);

        $this->assertTrue($calculatedFee->isEqualTo($expectedFee));
    }

    /**
     * @return array<array{0: int, 1: Money, 2: Money}>
     */
    public function calculatedFeeDataProvider(): array
    {
        return [
            [12, Money::of('200.00', 'PLN'), Money::of('3.00', 'PLN')],
            [24, Money::of('500.00', 'PLN'), Money::of('11.00', 'PLN')],
            [24, Money::of('400.00', 'PLN'), Money::of('9.00', 'PLN')],
            [24, Money::of('433.00', 'PLN'), Money::of('9.66', 'PLN')],
        ];
    }
}
