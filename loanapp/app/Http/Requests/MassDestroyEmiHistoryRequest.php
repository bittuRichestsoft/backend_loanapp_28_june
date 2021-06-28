<?php

namespace App\Http\Requests;

use App\EmiHistory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyEmiHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('loan_access'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:emi_history,id',
        ];
    }
}
