<style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f2f2f2;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    label {
        margin-bottom: 10px;
    }

    input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
        width: 200px;
    }

    .error {
        color: red;
        margin-bottom: 10px;
    }

    button {
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
</style>

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
