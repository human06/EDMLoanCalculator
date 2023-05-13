<?php

namespace App\Services;

class LoanCalculatorService
{



    public function Calculate($principal, $interest, $term, $extraPayment)
    {
        $monthlyInterestRate = ($interest / 12) / 100;
        $numberOfMonths = $term * 12;
        $monthlyPayment = ($principal * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfMonths));

        $amortizationSchedule = [];
        $extraRepaymentSchedule = [];
        $remainingPrincipal = $principal;
        $remainingLoanTerm = $term;

        for ($month = 1; $month <= $numberOfMonths; $month++) {
            // Calculate interest and principal payments
            $interestPayment = $remainingPrincipal * $monthlyInterestRate;
            $principalPayment = $monthlyPayment - $interestPayment;

            // Deduct extra payment from remaining loan balance
            if ($extraPayment > 0 && $remainingPrincipal > 0) {

                // if the extra patment is more than the remaining principal , then just go with the remaining principal
                if ($extraPayment >= $remainingPrincipal) {
                    $extraPayment = $remainingPrincipal;
                }

                $principalPayment += $extraPayment;
                $remainingPrincipal -= $principalPayment;

                // Ensure remaining principal does not go into negative
                if ($remainingPrincipal < 0) {
                    $remainingPrincipal = 0;
                }

                $remainingLoanTerm = $term - ($month / 12);

                $extraRepaymentSchedule[] = [
                    'month' => $month,
                    'starting_balance' => $remainingPrincipal + $principalPayment,
                    'monthly_payment' => $monthlyPayment,
                    'principal' => $principalPayment,
                    'interest' => $interestPayment,
                    'extra_repayment' => $extraPayment,
                    'ending_balance' => $remainingPrincipal,
                    'remaining_loan_term' => $remainingLoanTerm,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

            }
            else{
                $remainingPrincipal -= $principalPayment;
            }

            $totalPayment = $principalPayment + $interestPayment;

            $amortizationSchedule[] = [
                'month' => $month,
                'starting_balance' => $remainingPrincipal + $principalPayment,
                'monthly_payment' => $monthlyPayment,
                'principal' => $principalPayment,
                'interest' => $interestPayment,
                'ending_balance' => $remainingPrincipal,
            ];

        }

         return ['amortizationSchedule' => $amortizationSchedule, 'extraRepaymentSchedule' => $extraRepaymentSchedule];
    }

}
