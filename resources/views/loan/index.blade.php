


@extends('layouts.app')

@section('content')
<div class="container">
    <h1>EDM Loan Calculator Demo</h1>
    <p>Demo By : Hsn Rashid</p>
    <p>Enter the loan details below to calculate your estimated monthly payment.</p>
    <form action="{{ route('loan.calculate') }}" method="post" accept-charset="UTF-8">
        {{ csrf_field() }}

        <label for="principal">Loan Amount*</label>
        <input type="number" name="principal" id="principal" value="{{ old('principal') }}" required>
        @error('principal')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="interest">Annual Interest Rate*</label>
        <input type="number" name="interest" id="interest" value="{{ old('interest') }}" required>
        @error('interest')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="term">Loan Term (in years)*</label>
        <input type="number" name="term" id="term" value="{{ old('term') }}" required>
        @error('term')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="extra_payment">Monthly Fixed Extra Payment: (optional)</label>
        <input type="number" name="extra_payment" id="extra_payment" value="{{ old('extra_payment') }}">
        @error('extra_payment')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Calculate</button>
    </form>
</div>
@endsection