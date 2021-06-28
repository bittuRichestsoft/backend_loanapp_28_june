@extends('layout/home') @section('login')
  <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Reset Pin</h2>

                    <p>
                        Enter your Pin 
                    </p>
                    

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="get" action="{{url('api/v1/resetpinpost')}}">
                                  <input type="hidden" name="id" value="{{$id}}">
                          {{csrf_field()}}
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="new pin" name="new_pin" required="">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="confirm pin" name="confirm_pin" required="">
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