<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Services\LoanCalculatorService;
use Illuminate\Support\Facades\DB;
use App\Models\LoanAmortizationSchedule;
use App\Models\ExtraRepaymentSchedule;

class LoanController extends Controller
{
    //

    protected $loanCalculatorService;

    public function __construct(LoanCalculatorService $loanCalculatorService)
    {
        $this->loanCalculatorService = $loanCalculatorService;
    }

    public function index()
    {
        return view('loan.index');
    }

    public function calculate(LoanRequest $request)
    {

        \Log::info(json_encode($request->all()));

        // get the form input value
        $principal = $request->input('principal');
        $interest = $request->input('interest');
        $term = $request->input('term');
        $extraPayment = $request->input('extra_payment');

        $effectiveInterestRate = ($interest / 12) / 100; // Calculate the effective interest rate

        // Validate user values ...
        $validatedData = $request->validated();

        // calculate loan ...
        $results = $this->loanCalculatorService->Calculate($principal, $interest, $term, $extraPayment);

        $amortizationSchedule = $results['amortizationSchedule'];
        $extraRepaymentSchedule = $results['extraRepaymentSchedule'];
        $monthlyPayment = $amortizationSchedule[1]['monthly_payment'];

// save to db ...
// Save amortization schedule data to the database (no extra payment table )
        $amortizationData = [];

        foreach ($amortizationSchedule as $payment) {
            $amortizationData[] = [
                'month_number' => $payment['month'],
                'starting_balance' => $payment['starting_balance'],
                'monthly_payment' => $payment['monthly_payment'],
                'principal' => $payment['principal'],
                'interest' => $payment['interest'],
                'ending_balance' => $payment['ending_balance'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

         LoanAmortizationSchedule::insert($amortizationData);

// Save extra repayment schedule data to the database (extra payment table )
        $extraRepaymentData = [];

        foreach ($extraRepaymentSchedule as $payment) {
            $extraRepaymentData[] = [
                'month' => $payment['month'],
                'starting_balance' => $payment['starting_balance'],
                'monthly_payment' => $monthlyPayment,
                'principal' => $payment['principal'],
                'interest' => $payment['interest'],
                'extra_repayment' => $payment['extra_repayment'],
                'ending_balance' => $payment['ending_balance'],
                'remaining_loan_term' => $payment['remaining_loan_term'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ExtraRepaymentSchedule::insert($extraRepaymentData);
        // return view ..
        return view('loan.results', compact('principal', 'interest', 'term', 'extraPayment', 'monthlyPayment', 'effectiveInterestRate', 'amortizationSchedule', 'extraRepaymentSchedule'));

    }

}
