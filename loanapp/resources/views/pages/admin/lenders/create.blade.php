@extends('layouts/main')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
       <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Add Lender</h5>
            </div>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            @endif

            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif

            <div class="ibox-content">
           		{{ Form::open(['url'=> 'admin/lenders/save', 'method'=>'POST' , 'files' => true , 'class' => 'form-horizontal' ]) }}
    				{{csrf_field()}}
                    <div class="form-group"><label class="col-lg-2 control-label">Name</label>
                        <div class="col-lg-6">
                        	{{ Form::text('name' , '' , [ 'placeholder' => 'Name' , 'class' => 'form-control' , 'required' ]) }}
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-2 control-label">Email </label>
                        <div class="col-lg-6">
                        	{{ Form::email('email' , '' , [ 'placeholder' => 'Email' , 'class' => 'form-control' , 'required' ]) }}
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Phone </label>
                        <div class="col-lg-6">
                        	{{ Form::text('phone' , '' , [ 'placeholder' => 'Phone' , 'class' => 'form-control' , 'required' ]) }}
                        </div>
                    </div>

                      <div class="form-group"><label class="col-lg-2 control-label">Address </label>
                        <div class="col-lg-6">
                        	{{ Form::textarea('address' , '' , [ 'placeholder' => 'Address' , 'class' => 'form-control' , 'required' ]) }}
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-2 control-label">City</label>
                        <div class="col-lg-6">
                        	{{ Form::text('city' , '' , [ 'placeholder' => 'City' , 'class' => 'form-control' , 'required' ]) }}
                         </div>
                    </div>
                    <div class="form-group"><label class="col-lg-2 control-label">State</label>
                        <div class="col-lg-6">
                        	{{ Form::text('state' , '' , [ 'placeholder' => 'State' , 'class' => 'form-control' , 'required' ]) }}
                         </div>
                    </div>
                    <div class="form-group"><label class="col-lg-2 control-label">Country</label>
                        <div class="col-lg-6">
                        	{{ Form::text('country' , '' , [ 'placeholder' => 'Country' , 'class' => 'form-control' , 'required' ]) }}
                         </div>
                    </div>

                     <div class="form-group"><label class="col-lg-2 control-label">Zip</label>
                        <div class="col-lg-6">
                        	{{ Form::text('zip' , '' , [ 'placeholder' => 'Zip' , 'class' => 'form-control' , 'required' ]) }}
                         </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Latitude</label>
                        <div class="col-lg-6">
                        	{{ Form::text('lat' , '' , [ 'placeholder' => 'Latitude' , 'class' => 'form-control' , 'required' ]) }}
                         </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Longitude</label>
                        <div class="col-lg-6">
                        	{{ Form::text('lon' , '' , [ 'placeholder' => 'Longitude' , 'class' => 'form-control' , 'required' ]) }}
                         </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Profile Image</label>
                        <div class="col-lg-6">
                        	{{ Form::file('profile_image' , [ 'class' => 'form-control'  ]) }}
                         </div>    
                    </div>


                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            {{ Form::submit('Add Lender',['class'=>'btn btn-sm btn-primary']) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection