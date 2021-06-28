<?php

namespace App\Http\Requests;

use App\LoanReasons;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLoanReasonsRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('loan_access');
    }

    public function rules()
    {
        return [
            'name'    => [
                'required',
            ],  
        ];


    }
}
