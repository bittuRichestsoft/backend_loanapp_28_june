
@extends('layout/home') @section('login')
  <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Forgot Password</h2>

                    <p>
                        Enter your email address and your reset link will be  emailed to you.
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
@if(Session::get('success'))
              
    <div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  
           
                {{Session::get('success')}}
                </div>
          
     

@endif



                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="post" action="{{url('merchant/forgetpassword')}}">
                          {{csrf_field()}}
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email address" name="email" required="">
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
        
    </div>
    @endsection