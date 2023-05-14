<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // no need for authnticating the user ... 
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
       return [
            'principal' => 'required|numeric|min:1',
            'interest' => 'required|numeric|min:0',
            'term' => 'required|numeric|min:1|max:20',
            'extra_payment' => 'nullable|numeric|min:0',
       ];
    }

    public function massages() {
        return  [
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
        ];
    }
}
