@extends('layout/home') @section('login')
  <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Reset password</h2>

                    <p>
                        Enter your password 
                    </p>
                     <div>
                 @if ($errors->any())
    <div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
   <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    </div>
@endif

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="post" action="{{url('merchant/resetPassword')}}">
                                  <input type="hidden" name="id" value="{{$id}}">
                          {{csrf_field()}}
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="new password" name="new_password" required="">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="confirm password" name="confirm_password" required="">
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Update</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
       
    </div>
    @endsection