<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use Brick\Math\RoundingMode;
use Brick\Money\Money;
use LogicException;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Model\LoanFeeBreakpoint;

use function sprintf;
use function usort;

class FeeInterpolator
{
    public function interpolate(LoanProposal $application, LoanFeeBreakpoint ...$breakpointSeries): Money
    {
        $amount = $application->amount();

        usort(
            $breakpointSeries,
            fn (LoanFeeBreakpoint $a, LoanFeeBreakpoint $b): int => $a->amount() <=> $b->amount(),
        );

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
