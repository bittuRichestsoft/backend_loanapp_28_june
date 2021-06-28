@extends('layouts.main')
@section('content')
               
<div class="wrapper wrapper-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5 style="color: #ed5565;">Admin dashboard</h5>
        </div>
        <div class="ibox-content text-center">
          <h1 class="no-margins" style="color: #ed5565;"> 
            <i class="fa fa fa-user"></i>
          
          </h1>
          <div class="stat-percent font-bold text-success"></div>   
        </div>
      </div>
    </div>
  </div>
  <div class="row">

    <div class="col-lg-4">
      <a href="{{url('admin/users')}}">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <span class="label label-success pull-right">View</span>
            <h5 style="color: #ed5565;">Users ( 0 )</h5>
          </div>
          <div class="ibox-content">
            <h1 class="no-margins" style="color: #ed5565;"> 
              
            </h1>
            <div class="stat-percent font-bold text-success"></div>   
          </div>
        </div>
      </a>
    </div>

    <div class="col-lg-4">
      <a href="#">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <span class="label label-success pull-right">View</span>
            <h5 style="color: #ed5565;">Loan ( 0 )</h5>
          </div>
          <div class="ibox-content">
            <h1 class="no-margins" style="color: #ed5565;"> 
              
            </h1>
            <div class="stat-percent font-bold text-success"></div>   
          </div>
        </div>
      </a>
    </div>

    <div class="col-lg-4">
      <a href="#">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <span class="label label-success pull-right">View</span>
            <h5 style="color: #ed5565;">Transactions ( 0 )</h5>
          </div>
          <div class="ibox-content">
            <h1 class="no-margins" style="color: #ed5565;"> 
              
            </h1>
            <div class="stat-percent font-bold text-success"></div>   
          </div>
        </div>
      </a>
    </div>

    <!-- <div class="col-lg-4">
      <a href="{{url('admin/lenders')}}">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <span class="label label-success pull-right">View</span>
            <h5 style="color: #ed5565;">Lenders ( 0 )</h5>
          </div>
          <div class="ibox-content">
            <h1 class="no-margins" style="color: #ed5565;"> 
              
            </h1>
            <div class="stat-percent font-bold text-success"></div>   
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-4">
      <a href="{{url('admin/borrowers')}}">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
              <span class="label label-success pull-right">View</span>
            <h5 style="color: #ed5565;">Borrowers ( 0 )</h5>
          </div>
          <div class="ibox-content">
            <h1 class="no-margins" style="color: #ed5565;">
              
            </h1>
            <div class="stat-percent font-bold text-success"></div>
          </div>
        </div>
      </a>
    </div> -->


  </div>

  <div class="row">

  </div>
</div>

@endsection