<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', app_name())</title>
    {{Html::style('css/pdf.css')}}
</head>
<body>
	@if(!empty(access()->user()->locatario->logo))
	<img style='float:left;width:125px;max-height:50px;' src="{{ asset('img/logos/1.png') }}">
	@else
	<h1 id='locName'>{{access()->user()->locatario->fantasia}}</h1>
	@endif
	{{-- <img style='margin-left:78%;width:25px;height:auto;margin-top:2px' src="{{ asset('img/icon.png') }}"> --}}
    @yield('content')
</body>
</html>