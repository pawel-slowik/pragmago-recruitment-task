<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Model\LoanProposal;

class LoanFeeCalculator implements FeeCalculator
{
    public function calculate(LoanProposal $application): float
    {
        return 0;
    }
}
