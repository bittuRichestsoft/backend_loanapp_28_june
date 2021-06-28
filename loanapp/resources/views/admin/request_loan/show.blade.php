@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.loan_requests.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.loan_requests.fields.user_id') }}
                    </th>
                    <td>
                        {{ $requestLoan->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_requests.fields.amount') }}
                    </th>
                    <td>
                        {{ $requestLoan->amount }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_requests.fields.type') }}
                    </th>
                    <td>
                        {{ $requestLoan->type }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_requests.fields.to_be_paid') }}
                    </th>
                    <td>
                        {{ $requestLoan->to_be_paid }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_requests.fields.installment') }}
                    </th>
                    <td>
                        {{ $requestLoan->installment }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_requests.fields.interest_rate') }}
                    </th>
                    <td>
                        {{ $requestLoan->interest_rate }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_requests.fields.interest') }}
                    </th>
                    <td>
                        {{ $requestLoan->interest }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_requests.fields.created_by') }}
                    </th>
                    <td>
                        {{ $requestLoan->created_by }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_requests.fields.status') }}
                    </th>
                    <td>
                        {{ $requestLoan->status }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection