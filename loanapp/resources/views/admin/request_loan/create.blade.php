@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.loan_requests.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.loan_requests.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                <label for="user_id">{{ trans('global.loan_requests.fields.user_id') }}*</label>
                <input type="text" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($requestLoan) ? $requestLoan->user_id : '') }}">
                @if($errors->has('user_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_requests.fields.user_id_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                <label for="amount">{{ trans('global.loan_requests.fields.amount') }}*</label>
                <input type="text" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($requestLoan) ? $requestLoan->amount : '') }}">
                @if($errors->has('amount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_requests.fields.amount_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                <label for="type">{{ trans('global.loan_requests.fields.type') }}*</label>
                <input type="text" id="type" name="type" class="form-control" value="{{ old('type', isset($requestLoan) ? $requestLoan->type : '') }}">
                @if($errors->has('type'))
                    <em class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_requests.fields.type_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('to_be_paid') ? 'has-error' : '' }}">
                <label for="to_be_paid">{{ trans('global.loan_requests.fields.to_be_paid') }}*</label>
                <input type="text" id="to_be_paid" name="to_be_paid" class="form-control" value="{{ old('to_be_paid', isset($requestLoan) ? $requestLoan->to_be_paid : '') }}">
                @if($errors->has('to_be_paid'))
                    <em class="invalid-feedback">
                        {{ $errors->first('to_be_paid') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_requests.fields.to_be_paid_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('installment') ? 'has-error' : '' }}">
                <label for="to_be_paid">{{ trans('global.loan_requests.fields.installment') }}*</label>
                <input type="text" id="installment" name="installment" class="form-control" value="{{ old('installment', isset($requestLoan) ? $requestLoan->installment : '') }}">
                @if($errors->has('installment'))
                    <em class="invalid-feedback">
                        {{ $errors->first('installment') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_requests.fields.installment_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('interest_rate') ? 'has-error' : '' }}">
                <label for="to_be_paid">{{ trans('global.loan_requests.fields.interest_rate') }}*</label>
                <input type="text" id="interest_rate" name="interest_rate" class="form-control" value="{{ old('interest_rate', isset($requestLoan) ? $requestLoan->interest_rate : '') }}">
                @if($errors->has('interest_rate'))
                    <em class="invalid-feedback">
                        {{ $errors->first('interest_rate') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_requests.fields.interest_rate_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('interest') ? 'has-error' : '' }}">
                <label for="to_be_paid">{{ trans('global.loan_requests.fields.interest') }}*</label>
                <input type="text" id="interest" name="interest" class="form-control" value="{{ old('interest', isset($requestLoan) ? $requestLoan->interest : '') }}">
                @if($errors->has('interest'))
                    <em class="invalid-feedback">
                        {{ $errors->first('interest') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.loan_requests.fields.interest_helper') }}
                </p>
            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection