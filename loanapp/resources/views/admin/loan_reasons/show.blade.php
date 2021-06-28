@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.loan_reason.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.loan_reason.fields.name') }}
                    </th>
                    <td>
                        {{ $loanReason->name }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection