@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.loan_duration.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.loan_duration.fields.package_name') }}
                    </th>
                    <td>
                        {{ $loanDuration->package_name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_duration.fields.number') }}
                    </th>
                    <td>
                        {{ $loanDuration->number }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.loan_duration.fields.calendar_value') }}
                    </th>
                    <td>
                        {{ $loanDuration->calendar_value }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection