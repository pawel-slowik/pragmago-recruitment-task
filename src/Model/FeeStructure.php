<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

use LogicException;

use function sprintf;

class FeeStructure
{
    private int $term;

    /** @var FeeBreakpoint[] */
    private array $breakpoints = [];

    /**
     * @param iterable<FeeBreakpoint> $breakpoints
     */
    public function __construct(int $term, iterable $breakpoints)
    {
        $this->term = $term;
        foreach ($breakpoints as $breakpoint) {
            $this->addBreakpoint($breakpoint);
        }
    }

    public function term(): int
    {
        return $this->term;
    }

    /**
     * @return iterable<FeeBreakpoint>
     */
    public function breakpoints(): iterable
    {
        return $this->breakpoints;
    }

    public function addBreakpoint(FeeBreakpoint $breakpoint): void
    {
        foreach ($this->breakpoints as $existingBreakpoint) {
            if ($breakpoint->amount()->isEqualTo($existingBreakpoint->amount())) {
                throw new LogicException(
                    sprintf(
                        'can not add another breakpoint for the same amount: %s',
                        $breakpoint->amount(),
                    )
                );
            }
        }

        $this->breakpoints[] = $breakpoint;
    }
}
