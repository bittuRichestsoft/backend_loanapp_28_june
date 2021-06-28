
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse" id="menu"> 
         <ul class=" nav nav metismenu" id="side-menu">
            <li class="nav-header">
                    <div class="dropdown profile-element"> <!--<span>
                 
                  <img src ="#"  style="width: 40px; margin-top:10px;" class="img-circle"> 
                     </span>-->
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ ucwords( Auth::user()->name ) }}  </strong>
                     </span> <span class="text-muted text-xs block">Admin <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                      <!-- <li><a href="admin/pages/Admin/changepassword">Change Password</a></li>
                        <li class="divider"></li> -->
                        <li>
                            
                            {{ Form::open(['url'=> 'admin/logout', 'method'=>'POST' ]) }}
                                {{csrf_field()}}
                                <!-- <a href="{{url('logout')}}">Logout</a> -->
                                {{ Form::submit('Logout',['class'=>'btn btn-sm btn-primary' , 'style'=>'color: #293846;background-color: #fefefe !important; border-color: #fefefe;']) }}
                            {{ Form::close() }}
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
          
                </div>
            </li> 

            <li @if(Request::path()=="admin/dashboard") class="active"   @endif >
                <a href="{{ url('/admin/dashboard') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span> </a>
            </li>


            <li @if(Request::path()=="admin/users") class="active"   @endif >
                <a href="{{ url('/admin/users') }}"><i class="fa fa-user"></i> <span class="nav-label">Users</span> </a>
            </li>

            <!-- <li @if(Request::path()=="admin/borrowers") class="active" @endif>
                <a href="{{ url('/admin/borrowers') }}"><i class="fa fa-th-large"></i><span class="nav-label">Borrowers</span></a>
            </li>  

            <li @if(Request::path()=="admin/lenders") class="active" @endif>
                <a href="{{ url('/admin/lenders') }}"><i class="fa fa-th-large"></i><span class="nav-label">Lenders</span></a>
            </li> -->

            

            <!-- <li @if(Request::path()=="admin/permissions") class="active" @endif>
                <a href="{{ url('/admin/permissions') }}"><i class="fa fa-th-large"></i><span class="nav-label">Permissions</span></a>
            </li>  -->      
        </ul>
    </div>
</nav>