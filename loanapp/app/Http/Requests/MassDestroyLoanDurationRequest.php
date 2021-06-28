<?php

namespace App\Http\Requests;

use App\LoanDuration;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyLoanDurationRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('loan_access'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:loan_duration,id',
        ];
    }
}
