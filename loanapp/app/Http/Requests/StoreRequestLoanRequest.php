<?php

namespace App\Http\Requests;

use App\RequestLoan;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequestLoanRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('loan_access');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
            ],
            'amount' => [
                'required',
            ],
            'type' => [
                'required',
            ],
            'to_be_paid' => [
                'required',
            ],
            'installment' => [
                'required',
            ],
            'interest_rate' => [
                'required',
            ],
            'interest' => [
                'required',
            ],
            
        ];
    }
}
