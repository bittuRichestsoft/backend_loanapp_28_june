<?php

namespace App\Http\Requests;

use App\LoanAmount;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLoanAmountRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('loan_access');
    }

    public function rules()
    {
        return [
            'range_from'    => [
                // 'float', 
                'required',
            ],
            'range_to'   => [
                // 'float',
                'required',
            ],
            'amount' => [
                // 'float',
                'required',
            ],
        ];


    }
}
