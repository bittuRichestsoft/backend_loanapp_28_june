<html>
<head>
<title></title>
<style>
.theme-config{
display:none;
}
</style>
@include('home.includes.head')
</head>

<body class="gray-bg">
<div id="wrapper">
@include('home.includes.sidebar')
<div id="page-wrapper" class="gray-bg dashbard-1">
@include('home.includes.header')

@yield('content')
@yield('scripts')
@include('home.includes.footer')
@include('home.includes.js')  

</div>
</div>
 
        
</body>
</html>