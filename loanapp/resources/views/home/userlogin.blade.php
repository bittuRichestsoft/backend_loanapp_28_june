@extends('layout/login') 

@section('content')

<div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog">
        <div class="loginmodal-container" style='text-align: center;'>

            <!-- <img src="{{config('gift3r.logo')}}" height="200px"><br> -->

            @if( empty($promotion) )
                <div class="well">
                  <img src="{{config('gift3r.logo')}}" height="200px"><br>
                  <div class="alert alert-info"> <i class="fa fa-exclamation-triangle"></i>
                    Unfortunately this promotion has been claimed or not available anymore. Stay tuned for further promotions. <br/>Thank you!
                  </div>
                </div>
            @elseif( $promotion->expired() 
                    || !$promotion->hasCardsAvailable() 
                    || !$promotion->active() 
                    || $promotion->uniqHash() != $hash
            )
                <div class="well">
                  <img src="{{ $promotion->store->image ??  config('gift3r.logo') }}" style="width: 150px; height: 150px; min-width: 150px;" class="img-circle"> <br>
                  <h3 style="color: #ef4036">{{$promotion->store->name}}</h3> <br>
                  <div class="alert alert-info"> <i class="fa fa-exclamation-triangle"></i>
                      Unfortunately this promotion has been claimed or not available anymore. Stay tuned for further promotions. <br/>Thank you!  
                  </div>
                </div>
            @else
                <div class="row well">
                  <div class="row col-sm-12">
                    <img src="{{ $promotion->store->image ??  config('gift3r.logo') }}" style="width: 150px; height: 150px; min-width: 150px;" class="img-circle">
                  </div>
                  <div class="row col-sm-12">
                    <h3 style="color: #ef4036">{{$promotion->store->name}}</h3>
                  </div>
                  <div class="row col-sm-12">
                    <div class="media">
                      <!-- <div class="media-left media-middle">
                          <img src="{{ $promotion->store->image }}" style="width: 100px; height: 100px; min-width: 100px;" class="img-circle">
                      </div> -->
                      <div class="media-body">
                          <h4 class="media-heading">
                            <!-- <span style="color: #ef4036">{{$promotion->store->name}}</span> is sending you a -->
                              Complimentary eGift Card for <span style="color: #ef4036">Free</span>!</h4>
                          <h3> <span class="label label-danger">${{$promotion->giftcard->price}}</span> </h3>
                          <p>
                            Promotion Expiration <br/> <span class="label label-default">{{\Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $promotion->expires_at)->toFormattedDateString()}}</span>
                          </p>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="complimentary-alert"></div>

                <div id="complimentary-main-container">
                  <form action="#" method="post" id="complimentary-login-form">
                      <span>Login to Claim Your Free eGiftCard</span>
                      {{ csrf_field() }}
                      <input type="email" placeholder="Email" name="email" id="email" required="">
                      <input type="password" name="password" id="password" placeholder="Password" required="">
                      <input type="submit" name="login" id="complimentary-login" class="login loginmodal-submit complimentary-login" value="Login" data-promourl = "{{$promotion->retrieveLink()}}" >
                  </form>
                </div>
            @endif

            <div class="well">
              <div class="alert alert-info" ><p><b>Instructions:</b> To claim your free eGift card, download Gift3r App, and create an account. Once you have an account, return to this page, enter your credentials, and your eGift will be delivered instantly into your Gift3r App inbox. </p></div><hr> 
                <div> <p> You do not have Gift3r App yet? <br/> Get it and register now to receive your free card: </p></div>
                <a href="{{config('gift3r.app_links.android')}}" > <img src="{{config('gift3r.app_links.playstore_logo')}}"> </a>
                <a href="{{config('gift3r.app_links.iOS')}}" > <img src="{{config('gift3r.app_links.appstore_logo')}}"></a><br>
                <a href="https://www.gift3rapp.com"><img src="{{config('gift3r.logo')}}" height="100px"></a><br>
            </div>
        </div>
    </div>
</div>

@endsection