<?php

namespace App\Http\Requests;

use App\EmiHistory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmiHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('loan_access');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'loan_id' => [
                'required',
                'integer',
            ],
            'installment' => [
                'required',
            ],
        ];
    }
}
