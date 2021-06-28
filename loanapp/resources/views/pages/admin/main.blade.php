<!DOCTYPE html>
<html>
<head>
  @include('home-admin.includes.head')
</head>
<body>
	<div id="wrapper">	
	
			@include('includes.sidebar')

		<div id="page-wrapper" class="gray-bg">
			@include('includes.topbar')
			@yield('content')
			
		</div>
	</div>
</body>
	@include('home-admin.includes.foot')
</html>
