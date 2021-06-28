@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.emi_history.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.emi_history.fields.user_id') }}
                    </th>
                    <td>
                        {{ $emiHistory->user_id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.emi_history.fields.loan_id') }}
                    </th>
                    <td>
                        {{ $emiHistory->loan_id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.emi_history.fields.installment') }}
                    </th>
                    <td>
                        {{ $emiHistory->installment }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection