<nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse" id="menu"> 
                 <ul class=" nav nav metismenu" id="side-menu">
                    <li class="nav-header">
                            <div class="dropdown profile-element"> <span>
                        |<a href="merchant/pages/Merchant/merchantprofile"> <img src ="{{Session::get('user.image')}}" style="width: 40px; margin-top:10px;" class="img-circle"> </a>
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"> <?php echo Session::get('user.name') ?></strong>
                             </span> <span class="text-muted text-xs block">Merchant <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                              <li><a href="merchant/pages/Merchant/changepassword">change password</a></li>
                                <li class="divider"></li>
                                <li><a href="{{url('merchantlogout')}}">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                  
                        </div>
                    </li>

                    
                    <li @if(Request::path()=="merchant/dashboard") class="active"   @endif >

                        <a href="merchant/dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span> </a>
                          </li>

  
                <li @if(Request::path()=="merchant/pages/Merchant/gift_card") class="active" @endif>
                    
                    <a href="merchant/gift_card">
                    <i class="fa fa-credit-card"></i> 
                    <span class="nav-label">Gift Cards</span> 
                 
                    </a>
                   
                </li>

                  <li @if(Request::path()=="merchant/pages/Merchant/gift_card_to_user") class="active" @endif>    
                    <a href="merchant/gift_card_to_user">
                    <i class="fa fa-credit-card"></i> 
                    <span class="nav-label">Gift Cards to Users</span> 
                    </a>
                  </li>

                  <li @if(Request::path()=="merchant/pages/Merchant/help_tutorial") class="active" @endif>    
                    <a href="merchant/help_tutorial">
                    <i class="fa fa-user"></i> 
                    <span class="nav-label">Help/Tutorial</span> 
                    </a>
                  </li>
                  
                   <!--  <li @if(Request::path()=="merchant/pages/Merchant/users") class="active" @endif>
                        <a href="merchant/pages/Merchant/users"><i class="fa fa-th-large"></i> <span class="nav-label">Users</span></a>
                    </li>    --> 
                 
                   <!--  <li @if(Request::path()=="merchant/pages/Merchant/merchants") class="active" @endif>
                        <a href="merchant/pages/Merchant/merchants"><i class="fa fa-th-large"></i> <span class="nav-label">Manage Store</span></a>
                    </li>   --> 


                     <li @if(Request::path()=="merchant/pages/Merchant/merchantprofile") class="active" @endif>
                        <a href="merchant/pages/Merchant/merchantprofile"><i class="fa fa-user"></i> <span class="nav-label">View Profile</span></a>
                    </li>  

                    <li @if(Request::path()=="merchant/pages/Merchant/servants") class="active" @endif>
                        <a href="merchant/pages/Merchant/servants"><i class="fa fa-user"></i> <span class="nav-label">Employee Access</span></a>
                    </li>                    
                   
                  <li >
                        <a href="https://service-application.com/v3app/us/isprocess.php?step=1&partnercode=444715&tid=26&cid=&tokenkey=sgO982I7K8N24mGd" target="_blank"><i class="fa fa-money"></i> <span class="nav-label">Signup For Payment</span></a>
                    </li> 
                </ul>

            </div>
        </nav>