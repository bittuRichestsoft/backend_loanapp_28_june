<html>
    @include("home-admin.includes.head")
    <body>
      <div class="container">
        <!-- @yield('content') -->
        @if (Session::get('success'))
        <div class="alert alert-success alert-dismissable" style="margin-top:20px;margin-bottom:1px;width: 95.5%;margin-left: 20px;">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>          
        <ul>
           {{Session::get('success')}}
        </ul>
        </div>
        @endif

        <div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
          <div class="modal-dialog">
            <div class="loginmodal-container">
              <img src="{{ URL::asset('public/assets/img/Logo.jpg') }}">
              <br>
              @if(count($errors))
              <div class="alert alert-danger alert-dismissable" style="width: 95.5%;margin-left: 20px;">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
              </ul>
              </div>
              @endif                  
              <form action="{{url('admin/loginUser')}}" method="post">
                <span>Welcome</span>
                {{csrf_field()}}
                <input type="email" placeholder="Email" name="email" required=""> 
                <input type="password" name="password" placeholder="Password" required="">  
                <input type="submit" name="login" class="login loginmodal-submit" value="Login">     
              </form> 
            </div>
          </div>
        </div>
      </div>
    </body>
</html>