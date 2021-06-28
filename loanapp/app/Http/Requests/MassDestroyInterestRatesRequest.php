<?php

namespace App\Http\Requests;

use App\InterestRates;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyInterestRatesRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('loan_access'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:interest_rates,id',
        ];
    }
}
