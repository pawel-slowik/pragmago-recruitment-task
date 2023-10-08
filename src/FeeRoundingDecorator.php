<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use Brick\Math\RoundingMode;
use Brick\Money\Money;
use PragmaGoTech\Interview\Model\LoanProposal;

class FeeRoundingDecorator implements FeeCalculator
{
    private FeeCalculator $feeCalculator;

    public function __construct(
        FeeCalculator $feeCalculator
    ) {
        $this->feeCalculator = $feeCalculator;
    }

    public function calculate(LoanProposal $application): Money
    {
        $fee = $this->feeCalculator->calculate($application);

        return self::round($fee, $application->amount());
    }

    private static function round(Money $fee, Money $amount): Money
    {
        $total = $amount->plus($fee);

        $totalRoundedUpAmount = $total->getAmount()
            ->toBigRational()
            ->dividedBy(5)
            ->toScale(0, RoundingMode::UP)
            ->multipliedBy(5);
        $totalRoundedUp = Money::create($totalRoundedUpAmount, $total->getCurrency(), $total->getContext());

        $fee = $totalRoundedUp->minus($amount);

        return $fee;
    }
}
