<!DOCTYPE html>
<html>
@include("includes/head")
<body>
	<div id="wrapper">
		@if(Session::get('user.role')=='admin')
			@include('includes/admin_sidebar')
		@elseif(Session::get('user.role')=='merchant')
			@include('includes/merchant_sidebar')
		@endif 
		<div id="page-wrapper" class="gray-bg" >
			@include('includes/topbar')
			@yield('content')
			@include('includes/footer')
		</div>
	</div>
	@include('includes/scripts')
	@yield('scripts')
</body>
</html>
