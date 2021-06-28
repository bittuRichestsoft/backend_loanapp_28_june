<?php

namespace App\Http\Requests;

use App\IncomeSources;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyIncomeSourcesRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('loan_access'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:income_sources,id',
        ];
    }
}
