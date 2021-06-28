<?php

namespace App\Http\Requests;

use App\RequestLoan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyRequestLoanRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('loan_access'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:request_loan,id',
        ];
    }
}
