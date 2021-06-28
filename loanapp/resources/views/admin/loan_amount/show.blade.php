@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.income_sources.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.loan_amount.fields.range_from') }}
                    </th>
                    <td>
                        {{ $loanAmount->range_from }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_amount.fields.range_to') }}
                    </th>
                    <td>
                        {{ $loanAmount->range_to }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_amount.fields.amount') }}
                    </th>
                    <td>
                        {{ $loanAmount->amount }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection