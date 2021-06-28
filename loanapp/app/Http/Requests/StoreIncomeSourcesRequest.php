<?php

namespace App\Http\Requests;

use App\IncomeSources;
use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeSourcesRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('loan_access');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
        ];
    }
}
