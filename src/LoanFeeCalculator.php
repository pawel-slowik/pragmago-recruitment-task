<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use LogicException;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Model\LoanFeeBreakpoint;

use function array_filter;
use function ceil;
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

    public function calculate(LoanProposal $application): float
    {
        $breakpoints = self::getSeries(
            $application->term(),
            $this->loanFeeBreakpointRepository->listAll(),
        );

        $fee = self::interpolate($application, ...$breakpoints);

        return self::round($fee, $application->amount());
    }

    /**
     * @param iterable<LoanFeeBreakpoint> $breakpoints
     *
     * @return array<LoanFeeBreakpoint>
     */
    private static function getSeries(int $term, iterable $breakpoints): array
    {
        if (!is_array($breakpoints)) {
            $breakpoints = iterator_to_array($breakpoints);
        }

        $breakpoints = array_filter(
            $breakpoints,
            fn (LoanFeeBreakpoint $breakpoint): bool => $breakpoint->term() === $term,
        );

        usort(
            $breakpoints,
            fn (LoanFeeBreakpoint $a, LoanFeeBreakpoint $b): int => $a->amount() <=> $b->amount(),
        );

        return $breakpoints;
    }

    private static function interpolate(LoanProposal $application, LoanFeeBreakpoint ...$breakpointSeries): float
    {
        $amount = $application->amount();

        foreach ($breakpointSeries as $breakpoint) {
            if ($breakpoint->amount() <= $amount) {
                $left = $breakpoint;
            } else {
                $right = $breakpoint;
                break;
            }
        }

        if (!isset($left)) {
            throw new LogicException(
                sprintf(
                    'can\'t interpolate: left value not found for term = %d and amount = %f',
                    $application->term(),
                    $amount,
                )
            );
        }

        if (!isset($right)) {
            return $left->fee();
        }

        $amountDelta = $right->amount() - $left->amount();
        $feeDelta = $right->fee() - $left->fee();

        return $left->fee() + ($amount - $left->amount()) * $feeDelta / $amountDelta;
    }

    private static function round(float $fee, float $amount): float
    {
        $total = $amount + $fee;
        $totalRoundedUp = ceil($total / 5) * 5;
        $fee = $totalRoundedUp - $amount;

        return $fee;
    }
}
