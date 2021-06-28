<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="{{asset('servant/style.css')}}">
    
</head>
<body>

<section class="pin-section">
    <img src="{{config('gift3r.logo')}}" alt="logo" height="200px">
    <div class="pin-inner">
				
	@if(count($errors))
        <div class="alert alert-danger alert-dismissable" style="width: 95.5%; margin-left: 20px;">
        <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                
        @foreach ($errors->all() as $error)
            <span class="error">{{ $error }}</span>
        @endforeach
    </div>
    @endif
        	
 @if (Session::get('success'))
    <div class="alert alert-success alert-dismissable" style="
    margin-top: 20px;
    margin-bottom:  1px;
    width: 95.5%;
    margin-left: 20px;
">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  
                    
        <ul>
           {{Session::get('success')}}
        </ul>
    </div>
    @endif
					<form method="post" action="{{url('employee/login')}}">
                       <input type="hidden" name="_token" value="{{csrf_token()}}"> 
                <div class="form-group">
                    <label for="pin">PIN:</label>
                    <input type="hidden" name="store_id" value="<?php echo $store_id; ?>">
                    <input class="form-control" type="text" name="employee_pin" id="pin">
                    <input class="btn" type="submit" value="Enter">
                </div>
            </form>
           
				</div>
			</div>
		  </div>
</body>
</html>