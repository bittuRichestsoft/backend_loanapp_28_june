@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.interest_rates.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.interest_rates.fields.rate') }}
                    </th>
                    <td>
                        {{ $interestRate->rate }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection