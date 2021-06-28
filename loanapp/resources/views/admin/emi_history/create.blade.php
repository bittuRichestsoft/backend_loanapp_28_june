@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.emi_history.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.emi_history.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                <label for="user_id">{{ trans('global.emi_history.fields.user_id') }}*
                    <!-- <span class="btn btn-info btn-xs select-all">Select all</span> -->
                <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
                <select name="user_id" id="user_id" class="form-control select2">
                    @foreach($users as $id => $users)
                        <option value="{{ $users->id }}" >
                            {{ $users->first_name }} &nbsp; {{ $users->last_name }} 
                        </option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.emi_history.fields.user_id_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('loan_id') ? 'has-error' : '' }}">
                <label for="loan_id">{{ trans('global.emi_history.fields.loan_id') }}*
                    <!-- <span class="btn btn-info btn-xs select-all">Select all</span> -->
                <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
                <select name="loan_id" id="loan_id" class="form-control select2" >
                    @foreach($loan_id as $id => $loan_id)
                        <option value="{{ $loan_id->id }}">
                            {{ $loan_id->amount }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('loan_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('loan_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.emi_history.fields.loan_id_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('installment') ? 'has-error' : '' }}">
                <label for="installment">{{ trans('global.emi_history.fields.installment') }}*</label>
                <input type="text" id="installment" name="installment" class="form-control" value="{{ old('installment', isset($emiHistory) ? $emiHistory->name : '') }}">
                @if($errors->has('installment'))
                    <em class="invalid-feedback">
                        {{ $errors->first('installment') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.emi_history.fields.installment_helper') }}
                </p>
            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection