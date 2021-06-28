@extends('layouts/main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Users</h2>
    <ol class="breadcrumb">
      <li>
        <a href="{{url('admin/dashboard')}}">home</a>
      </li>
      <li class="active">
          <strong>Users</strong>    
      </li>
    </ol>
  </div>
</div>

@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
<div class="wrapper wrapper-content  animated fadeInRight">

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <a class='btn btn-primary' href="{{ url('/admin/users/create')}}">Add User</a>
        </div>
        <div class="ibox-content">
          <div class="row table-overflow">       
            <table class="table table-condensed table-hover table-responsive" id="user-table">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Profile Image</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Country</th>
                  <th>Zip</th>
                  <th>Latitude </th>
                  <th>Longitude </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @if( $users )
                  @foreach( $users as $users_data )
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ ucwords($users_data->name) }}</td>
                      <td>{{ $users_data->email }}</td>
                      <td>{{ $users_data->phone }}</td>
                      <td>
                        @if( $users_data->profile_image)
                          <img width="50" height="50" src="{{ asset('public/profile_images') }}/{{ $users_data->profile_image }}" >
                        @endif
                      </td>
                      <td>{{ $users_data->address }}</td>
                      <td>{{ $users_data->city }}</td>
                      <td>{{ $users_data->state }}</td>
                      <td>{{ $users_data->country }}</td>
                      <td>{{ $users_data->zip }}</td>
                      <td>{{ $users_data->lat }}</td>
                      <td>{{ $users_data->lon }}</td>
                      <td>
                        <a class='btn btn-primary' href="{{ url('/admin/users/edit')}}/{{ $users_data->id }}">Edit</a>
                        <a class='btn btn-primary' href="{{ url('/admin/users/delete')}}/{{ $users_data->id }}">Delete</a>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr><td colspan ='5'></td></tr>
                @endif
              </tbody>
            </table>
              
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection