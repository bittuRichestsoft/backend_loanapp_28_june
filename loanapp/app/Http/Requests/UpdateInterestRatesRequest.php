<?php

namespace App\Http\Requests;

use App\InterestRates;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInterestRatesRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('loan_access');
    }

    public function rules()
    {
        return [
            'rate' => [
                'required',
            ],
        ];
    }
}
