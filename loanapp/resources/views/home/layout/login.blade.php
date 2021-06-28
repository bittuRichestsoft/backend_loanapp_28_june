<html>
<head>
<style>

.custom{
  border-radius: 100px;     
}
.customb{
  background-color: #3279b6;
  border-color: #1ab394;
  border-radius: 100px; 
}
.bodyC{
	background-color: lightgrey;
}

</style>
<title></title>
@include('home.includes.head')
</head>

<body class="bg-img">
@yield('content')

<script src="assets/js/jquery-2.1.1.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>