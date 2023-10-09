<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use Brick\Math\RoundingMode;
use Brick\Money\Money;
use LogicException;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Model\LoanFeeBreakpoint;

use function iterator_to_array;
use function is_array;
use function sprintf;
use function usort;

class LoanFeeCalculator implements FeeCalculator
{
    private LoanFeeBreakpointRepository $loanFeeBreakpointRepository;

    public function __construct(
        LoanFeeBreakpointRepository $loanFeeBreakpointRepository
    ) {
        $this->loanFeeBreakpointRepository = $loanFeeBreakpointRepository;
    }

    public function calculate(LoanProposal $application): Money
    {
        $breakpoints = $this->loanFeeBreakpointRepository->listForTerm($application->term());
        if (!is_array($breakpoints)) {
            $breakpoints = iterator_to_array($breakpoints);
        }

        usort(
            $breakpoints,
            fn (LoanFeeBreakpoint $a, LoanFeeBreakpoint $b): int => $a->amount() <=> $b->amount(),
        );

        return self::interpolate($application, ...$breakpoints);
    }

    private static function interpolate(LoanProposal $application, LoanFeeBreakpoint ...$breakpointSeries): Money
    {
        $amount = $application->amount();

        foreach ($breakpointSeries as $breakpoint) {
            if ($breakpoint->amount()->isLessThanOrEqualTo($amount)) {
                $left = $breakpoint;
            } else {
                $right = $breakpoint;
                break;
            }
        }

        if (!isset($left)) {
            throw new LogicException(
                sprintf(
                    'can\'t interpolate: left value not found for term = %d and amount = %s',
                    $application->term(),
                    $amount,
                )
            );
        }

        if (!isset($right)) {
            return $left->fee();
        }

        $amountStep = $right->amount()->minus($left->amount());
        $feeStep = $right->fee()->minus($left->fee());
        $amountDelta = $amount->minus($left->amount());
        $coefficient = $feeStep->getAmount()->toBigRational()->dividedBy($amountStep->getAmount()->toBigRational());
        $feeDelta = $amountDelta->multipliedBy($coefficient, RoundingMode::HALF_EVEN);

        return $left->fee()->plus($feeDelta);
    }
}
