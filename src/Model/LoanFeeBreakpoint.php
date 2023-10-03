<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

class LoanFeeBreakpoint
{
    private int $term;

    private float $amount;

    private float $fee;

    public function __construct(int $term, float $amount, float $fee)
    {
        $this->term = $term;
        $this->amount = $amount;
        $this->fee = $fee;
    }

    public function term(): int
    {
        return $this->term;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function fee(): float
    {
        return $this->fee;
    }
}
