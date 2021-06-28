@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.interest_rates.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.interest_rates.update", [$interestRate->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('rate') ? 'has-error' : '' }}">
                <label for="rate">{{ trans('global.interest_rates.fields.rate') }}*</label>
                <input type="text" id="rate" name="rate" class="form-control" value="{{ old('rate', isset($interestRate) ? $interestRate->rate : '') }}">
                @if($errors->has('rate'))
                    <em class="invalid-feedback">
                        {{ $errors->first('rate') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.interest_rates.fields.rate_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection