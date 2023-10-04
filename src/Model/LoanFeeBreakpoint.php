<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

use Brick\Money\Money;

class LoanFeeBreakpoint
{
    private int $term;

    private Money $amount;

    private Money $fee;

    public function __construct(int $term, Money $amount, Money $fee)
    {
        $this->term = $term;
        $this->amount = $amount;
        $this->fee = $fee;
    }

    public function term(): int
    {
        return $this->term;
    }

    public function amount(): Money
    {
        return $this->amount;
    }

    public function fee(): Money
    {
        return $this->fee;
    }
}
