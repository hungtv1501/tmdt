<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>demo view laravel</title>
	<link rel="stylesheet" href="{{ asset('css/test/bootstrap.min.css') }}">
	{{-- nhung doan code css nam trong file view con se duoc hien thi o day --}}
	@stack('css')
</head>
<body>
	<div class="container-fluid">
		
		{{-- nhung header view --}}
		@include('common.header')

		{{-- nhung menu view --}}
		@include('common.menu')

		{{-- nhan du lieu tu cac file view truyen sang --}}
		@yield('content')

		{{-- nhung footer view --}}
		@include('common.footer')
	</div>
	
	<script type="text/javascript" src="{{ asset('js/test/jquery-3.3.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/test/bootstrap.min.js') }}"></script>
	
	{{-- nghia la : sau nay nhung file js duoc viet trong cac file view con thi se duoc hien thi o day --}}
	@stack('js')

</body>
</html>