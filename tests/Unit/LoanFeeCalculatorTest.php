<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Unit;

use Brick\Money\Money;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\FeeInterpolator;
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

    /** @var FeeInterpolator&MockObject */
    private FeeInterpolator $feeInterpolator;

    protected function setUp(): void
    {
        $this->loanFeeBreakpointRepository = $this->createStub(LoanFeeBreakpointRepository::class);
        $this->feeInterpolator = $this->createMock(FeeInterpolator::class);
        $this->loanFeeCalculator = new LoanFeeCalculator(
            $this->loanFeeBreakpointRepository,
            $this->feeInterpolator,
        );
    }

    public function testCalculation(): void
    {
        $proposal = $this->createStub(LoanProposal::class);
        $proposal->method('term')->willReturn(12);
        $proposal->method('amount')->willReturn(Money::of('1.23', 'PLN'));

        $breakpoints = [
            new LoanFeeBreakpoint(12, Money::of('5.00', 'PLN'), Money::of('0.25', 'PLN')),
            new LoanFeeBreakpoint(12, Money::of('7.00', 'PLN'), Money::of('0.33', 'PLN')),
        ];

        $this->loanFeeBreakpointRepository
            ->method('listForTerm')
            ->willReturn($breakpoints);

        $this->feeInterpolator
            ->expects($this->once())
            ->method('interpolate')
            ->with(
                $proposal,
                ...$breakpoints
            )
            ->willReturn(Money::of('6.00', 'PLN'));

        $calculatedFee = $this->loanFeeCalculator->calculate($proposal);

        $this->assertTrue($calculatedFee->isEqualTo(Money::of('6.00', 'PLN')));
    }
}
