<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Model\LoanFeeBreakpoint;

class LoanFeeBreakpointRepository
{
    /**
     * @return iterable<LoanFeeBreakpoint>
     */
    public function listAll(): iterable
    {
        return [
            new LoanFeeBreakpoint(12,  1000,  50),
            new LoanFeeBreakpoint(12,  2000,  90),
            new LoanFeeBreakpoint(12,  3000,  90),
            new LoanFeeBreakpoint(12,  4000, 115),
            new LoanFeeBreakpoint(12,  5000, 100),
            new LoanFeeBreakpoint(12,  6000, 120),
            new LoanFeeBreakpoint(12,  7000, 140),
            new LoanFeeBreakpoint(12,  8000, 160),
            new LoanFeeBreakpoint(12,  9000, 180),
            new LoanFeeBreakpoint(12, 10000, 200),
            new LoanFeeBreakpoint(12, 11000, 220),
            new LoanFeeBreakpoint(12, 12000, 240),
            new LoanFeeBreakpoint(12, 13000, 260),
            new LoanFeeBreakpoint(12, 14000, 280),
            new LoanFeeBreakpoint(12, 15000, 300),
            new LoanFeeBreakpoint(12, 16000, 320),
            new LoanFeeBreakpoint(12, 17000, 340),
            new LoanFeeBreakpoint(12, 18000, 360),
            new LoanFeeBreakpoint(12, 19000, 380),
            new LoanFeeBreakpoint(12, 20000, 400),
            new LoanFeeBreakpoint(24,  1000,  70),
            new LoanFeeBreakpoint(24,  2000, 100),
            new LoanFeeBreakpoint(24,  3000, 120),
            new LoanFeeBreakpoint(24,  4000, 160),
            new LoanFeeBreakpoint(24,  5000, 200),
            new LoanFeeBreakpoint(24,  6000, 240),
            new LoanFeeBreakpoint(24,  7000, 280),
            new LoanFeeBreakpoint(24,  8000, 320),
            new LoanFeeBreakpoint(24,  9000, 360),
            new LoanFeeBreakpoint(24, 10000, 400),
            new LoanFeeBreakpoint(24, 11000, 440),
            new LoanFeeBreakpoint(24, 12000, 480),
            new LoanFeeBreakpoint(24, 13000, 520),
            new LoanFeeBreakpoint(24, 14000, 560),
            new LoanFeeBreakpoint(24, 15000, 600),
            new LoanFeeBreakpoint(24, 16000, 640),
            new LoanFeeBreakpoint(24, 17000, 680),
            new LoanFeeBreakpoint(24, 18000, 720),
            new LoanFeeBreakpoint(24, 19000, 760),
            new LoanFeeBreakpoint(24, 20000, 800),
        ];
    }
}
