<?php

namespace App\Http\Requests;

use App\LoanOffers;
use Illuminate\Foundation\Http\FormRequest;

class StoreLoanOffersRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('loan_access');
    }

    public function rules()
    {
        return [
            'user_id'    => [
                'required',
            ],
            'amount'    => [
                'required',
            ],
            'to_be_paid'    => [
                'required',
            ],
            'interest'    => [
                'required',
            ],
            'installment'    => [
                'required',
            ],
            'type'    => [
                'required',
            ],
            'given_to'    => [
                'required',
            ],
            'status'    => [
                'required',
            ],
            'taken_by'    => [
                'required',
            ],
        ];
    }
}
