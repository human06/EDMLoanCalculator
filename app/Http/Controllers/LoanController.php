<?php

namespace App\Http\Controllers;

use App\Services\LoanCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function calculate(Request $request)
    {

        \Log::info(json_encode($request->all()));

        // get the form input value
        $principal = $request->input('principal');
        $interest = $request->input('interest');
        $term = $request->input('term');
        $extraPayment = $request->input('extra_payment');

        $effectiveInterestRate = ($interest / 12) / 100; // Calculate the effective interest rate

        // Validate user values ...
        $validatedData = $request->validate(
            [
                'principal' => 'required|numeric|min:1',
                'interest' => 'required|numeric|min:0',
                'term' => 'required|numeric|min:1|max:20',
                'extra_payment' => 'nullable|numeric|min:0',
            ],
            [
                'principal.required' => 'The loan amount is required.',
                'principal.numeric' => 'The loan amount must be a number.',
                'principal.min' => 'The loan amount must be a non-negative value.',
                'interest.required' => 'The annual interest rate is required.',
                'interest.numeric' => 'The annual interest rate must be a number.',
                'interest.min' => 'The annual interest rate must be a non-negative value.',
                'term.required' => 'The loan term is required.',
                'term.numeric' => 'The loan term must be a number.',
                'term.min' => 'The loan term must be a btween a year to 20 years.',
                'term.max' => 'The loan term must not exceed 20 years.',
                'extra_payment.numeric' => 'The monthly fixed extra payment must be a number.',
                'extra_payment.min' => 'The monthly fixed extra payment must be a non-negative value.',
            ]);

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

        DB::table('loan_amortization_schedule')->insert($amortizationData);

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

        DB::table('extra_repayment_schedule')->insert($extraRepaymentData);

        // return view ..
        return view('loan.results', compact('principal', 'interest', 'term', 'extraPayment', 'monthlyPayment', 'effectiveInterestRate', 'amortizationSchedule', 'extraRepaymentSchedule'));

    }

}
