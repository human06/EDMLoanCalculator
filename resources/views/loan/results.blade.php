
<!-- resources/views/loan/results.blade.php -->

<style>
.amortization-table {
    width: 100%;
    border-collapse: collapse;
    padding: 10px;
}

.amortization-table th,
.amortization-table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
}

.amortization-table thead th {
    background-color: #f2f2f2;
}

.result-info {
        margin-bottom: 20px;
    }

    .result-info p {
        margin-bottom: 10px;
    }



    .card {
    border: 1px solid #ccc;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    background-color: #fff;
}

.card-content {
    /* Add any additional styling for the card content */
}

.card-title {
    font-size: 18px;
    margin: 0 0 10px;
}

.card-description {
    font-size: 14px;
    color: #666;
}

</style>

@extends('layouts.app')

@section('content')



<div class="card">
<div class="card-title"> <h1>EDM Loan Calculation Results</h2></div>
<div class="card-description"> 

<div class="result-info">
    <p><strong>Loan Amount:</strong> ${{ $principal }}</p>
    <p><strong>Annual Interest Rate:</strong> {{ $interest }}%</p>
    <p><strong>Loan Term:</strong> {{ $term }} years</p>
    <p><strong>Monthly Fixed Extra Payment:</strong> ${{ $extraPayment }}</p>
    <p><strong>Monthly Payment:</strong> ${{ number_format($monthlyPayment, 2) }}</p>
    <p><strong>Effective Interest Rate: </strong> {{ $effectiveInterestRate }}%</p>

</div>
</div>
</div>





@if (empty($extraRepaymentSchedule) )
<h4>Amortization Schedule (without Extra Payment)</h4>

<table class="amortization-table">
    <thead>
        <tr>
            <th>Month</th>
            <th>Beginning Balance</th>
            <th>Payment</th>

            <th>Principal</th>
            <th>Interest</th>
                        <th>Ending Balance</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($amortizationSchedule as $payment)
            <tr>
                <td>{{ $payment['month'] }}</td>
                <td>{{ number_format($payment['starting_balance'], 3) }}</td>
                <td>{{ number_format($payment['monthly_payment'], 3) }}</td>

                <td>{{ number_format($payment['principal'], 3) }}</td>
                <td>{{ number_format($payment['interest'], 3) }}</td>
                <td>{{ number_format($payment['ending_balance'], 3) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endif

@if (!empty($extraRepaymentSchedule) )

<h4>Amortization Schedule (with Extra Fixed Extra Payment of ${{ $extraPayment }})</h4>
<table class="amortization-table">
    <thead>
        <tr>
            <th>Month</th>
            <th>Starting Balance</th>
            <th>Monthly Payment</th>
            <th>Principal</th>
            <th>Interest</th>
            <th>Extra Repayment</th>
            <th>Ending Balance</th>
            <th>Remaining Loan Term</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($extraRepaymentSchedule as $payment)
            <tr>
                <td>{{ $payment['month'] }}</td>
                <td>{{ number_format($payment['starting_balance'], 3) }}</td>
                <td>{{ number_format($payment['monthly_payment'], 3) }}</td>
                <td>{{ number_format($payment['principal'], 3) }}</td>
                <td>{{ number_format($payment['interest'], 3) }}</td>
                <td>{{ number_format($payment['extra_repayment'], 3) }}</td>
                <td>{{ number_format($payment['ending_balance'], 3) }}</td>
                <td>{{ number_format($payment['remaining_loan_term'], 3) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection
