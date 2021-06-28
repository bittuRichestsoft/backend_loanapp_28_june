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
                        {{ trans('global.income_sources.fields.name') }}
                    </th>
                    <td>
                        {{ $incomeSource->name }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection