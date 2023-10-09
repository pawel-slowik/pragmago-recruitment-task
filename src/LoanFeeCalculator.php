<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use Brick\Money\Money;
use PragmaGoTech\Interview\Model\LoanProposal;

use function iterator_to_array;
use function is_array;

class LoanFeeCalculator implements FeeCalculator
{
    private LoanFeeBreakpointRepository $loanFeeBreakpointRepository;

    private FeeInterpolator $feeInterpolator;

    public function __construct(
        LoanFeeBreakpointRepository $loanFeeBreakpointRepository,
        FeeInterpolator $feeInterpolator
    ) {
        $this->loanFeeBreakpointRepository = $loanFeeBreakpointRepository;
        $this->feeInterpolator = $feeInterpolator;
    }

    public function calculate(LoanProposal $application): Money
    {
        $breakpoints = $this->loanFeeBreakpointRepository->listForTerm($application->term());
        if (!is_array($breakpoints)) {
            $breakpoints = iterator_to_array($breakpoints);
        }

        return $this->feeInterpolator->interpolate($application, ...$breakpoints);
    }
}
