<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use Brick\Money\Money;
use PragmaGoTech\Interview\Model\LoanProposal;

use function iterator_to_array;
use function is_array;

class LoanFeeCalculator implements FeeCalculator
{
    private FeeStructureRepository $feeStructureRepository;

    private FeeInterpolator $feeInterpolator;

    public function __construct(
        FeeStructureRepository $feeStructureRepository,
        FeeInterpolator $feeInterpolator
    ) {
        $this->feeStructureRepository = $feeStructureRepository;
        $this->feeInterpolator = $feeInterpolator;
    }

    public function calculate(LoanProposal $application): Money
    {
        $structure = $this->feeStructureRepository->getForTerm($application->term());
        $breakpoints = $structure->breakpoints();
        if (!is_array($breakpoints)) {
            $breakpoints = iterator_to_array($breakpoints);
        }

        return $this->feeInterpolator->interpolate($application, ...$breakpoints);
    }
}
