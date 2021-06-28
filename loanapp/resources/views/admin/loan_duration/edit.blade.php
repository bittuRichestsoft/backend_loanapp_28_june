@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.loan_duration.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.loan_duration.update", [$loanDuration->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('package_name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.loan_duration.fields.package_name') }}*</label>
                <input type="text" id="package_name" name="package_name" class="form-control" value="{{ old('name', isset($loanDuration) ? $loanDuration->package_name : '') }}">
                @if($errors->has('package_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('package_name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_duration.fields.package_name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('number') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.loan_duration.fields.number') }}*</label>
                <input type="text" id="number" name="number" class="form-control" value="{{ old('name', isset($loanDuration) ? $loanDuration->number : '') }}">
                @if($errors->has('number'))
                    <em class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_duration.fields.number_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('calendar_value') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.loan_duration.fields.calendar_value') }}*</label>
                <input type="text" id="calendar_value" name="calendar_value" class="form-control" value="{{ old('name', isset($loanDuration) ? $loanDuration->calendar_value : '') }}">
                @if($errors->has('calendar_value'))
                    <em class="invalid-feedback">
                        {{ $errors->first('calendar_value') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_duration.fields.calendar_value_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection