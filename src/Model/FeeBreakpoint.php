<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

use Brick\Money\Money;

class FeeBreakpoint
{
    private Money $amount;

    private Money $fee;

    public function __construct(Money $amount, Money $fee)
    {
        $this->amount = $amount;
        $this->fee = $fee;
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
