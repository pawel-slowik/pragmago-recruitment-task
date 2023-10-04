<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use Brick\Money\Money;
use PragmaGoTech\Interview\Model\LoanFeeBreakpoint;

class LoanFeeBreakpointRepository
{
    /**
     * @return iterable<LoanFeeBreakpoint>
     */
    public function listAll(): iterable
    {
        // phpcs:disable PEAR.Functions.FunctionCallSignature.SpaceAfterOpenBracket
        // phpcs:disable PSR2.Methods.FunctionCallSignature.SpaceAfterOpenBracket
        return [
            new LoanFeeBreakpoint(12, Money::of( 1000, 'PLN'), Money::of( 50, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of( 2000, 'PLN'), Money::of( 90, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of( 3000, 'PLN'), Money::of( 90, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of( 4000, 'PLN'), Money::of(115, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of( 5000, 'PLN'), Money::of(100, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of( 6000, 'PLN'), Money::of(120, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of( 7000, 'PLN'), Money::of(140, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of( 8000, 'PLN'), Money::of(160, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of( 9000, 'PLN'), Money::of(180, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(10000, 'PLN'), Money::of(200, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(11000, 'PLN'), Money::of(220, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(12000, 'PLN'), Money::of(240, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(13000, 'PLN'), Money::of(260, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(14000, 'PLN'), Money::of(280, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(15000, 'PLN'), Money::of(300, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(16000, 'PLN'), Money::of(320, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(17000, 'PLN'), Money::of(340, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(18000, 'PLN'), Money::of(360, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(19000, 'PLN'), Money::of(380, 'PLN')),
            new LoanFeeBreakpoint(12, Money::of(20000, 'PLN'), Money::of(400, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of( 1000, 'PLN'), Money::of( 70, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of( 2000, 'PLN'), Money::of(100, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of( 3000, 'PLN'), Money::of(120, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of( 4000, 'PLN'), Money::of(160, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of( 5000, 'PLN'), Money::of(200, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of( 6000, 'PLN'), Money::of(240, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of( 7000, 'PLN'), Money::of(280, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of( 8000, 'PLN'), Money::of(320, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of( 9000, 'PLN'), Money::of(360, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(10000, 'PLN'), Money::of(400, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(11000, 'PLN'), Money::of(440, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(12000, 'PLN'), Money::of(480, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(13000, 'PLN'), Money::of(520, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(14000, 'PLN'), Money::of(560, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(15000, 'PLN'), Money::of(600, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(16000, 'PLN'), Money::of(640, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(17000, 'PLN'), Money::of(680, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(18000, 'PLN'), Money::of(720, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(19000, 'PLN'), Money::of(760, 'PLN')),
            new LoanFeeBreakpoint(24, Money::of(20000, 'PLN'), Money::of(800, 'PLN')),
        ];
        // phpcs:enable
    }
}
