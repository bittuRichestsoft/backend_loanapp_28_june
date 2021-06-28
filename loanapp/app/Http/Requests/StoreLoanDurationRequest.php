<?php

namespace App\Http\Requests;

use App\LoanDuration;
use Illuminate\Foundation\Http\FormRequest;

class StoreLoanDurationRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('loan_access');
    }

    public function rules()
    {
        return [
            'package_name'    => [
                'required',
            ],
            'number'   => [
                'required',
                'integer',
            ],
            'calendar_value' => [
                'required',
            ],
        ];
    }
}
