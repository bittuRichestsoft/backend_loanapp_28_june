@extends('layout/login') 

@section('content')

@php
if (Request::is('admin/*')) {
    $currentLoginType = "admin";
}
elseif (Request::is('merchant/*')) 
{
    $currentLoginType = "merchant";
}
else
{
    abort(403, 'Unauthorized action.');
}
@endphp

<div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog">
        <div class="loginmodal-container text-center">
            <img src="{{config('gift3r.logo')}}" height="250px"><br>

            @if(count($errors))
            <div class="alert alert-danger alert-dismissable text-left" style="width:95.5%;margin-left:20px;">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
            </div>
            @endif

            @if (Session::get('success'))
              <div class="alert alert-success alert-dismissable" style="margin-top: 20px;margin-bottom: 1px;width: 95.5%;margin-left: 20px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <ul>
                   {{Session::get('success')}}
                </ul>
              </div>
            @endif

            <form action="{{ url($currentLoginType . '/login') }}" method="post">
                <span>Welcome to Gift3r App</span>
                {{ csrf_field() }}
                <input type="email" placeholder="Email" name="email" required="" value="{{ old('email') }}">
                <input type="password" name="password" placeholder="Password" required="">
                <input type="submit" name="login" class="login loginmodal-submit" value="Login">
            </form>
            @if ( $currentLoginType == "merchant" )
            <a class="forgot-pass" style="float: right;text-align: right;" href="{{url($currentLoginType . '/forgetpassword')}}">Forgot Password</a>
            @endif
        </div>
    </div>
</div>

@endsection