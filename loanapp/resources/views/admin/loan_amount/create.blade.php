@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.loan_amount.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.loan_amount.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('range_from') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.loan_amount.fields.range_from') }}*</label>
                <input type="text" id="range_from" name="range_from" class="form-control" value="{{ old('range_from', isset($loanAmount) ? $loanAmount->range_from : '') }}">
                @if($errors->has('range_from'))
                    <em class="invalid-feedback">
                        {{ $errors->first('range_from') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_amount.fields.range_from_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('range_to') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.loan_amount.fields.range_to') }}*</label>
                <input type="text" id="range_to" name="range_to" class="form-control" value="{{ old('range_to', isset($loanAmount) ? $loanAmount->range_to : '') }}">
                @if($errors->has('range_to'))
                    <em class="invalid-feedback">
                        {{ $errors->first('range_to') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_amount.fields.range_to_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.loan_amount.fields.amount') }}*</label>
                <input type="text" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($loanAmount) ? $incomeSource->amount : '') }}">
                @if($errors->has('amount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_amount.fields.amount_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection