<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', app_name())</title>
    {{Html::style('css/pdf.css')}}
</head>
<body>
	<header style='width:60%;display:inline-block'>@yield('header')</header>
	@if(!empty(access()->user()->locatario->logo))
	<img style='width:15%;max-height:50px;margin-left:25%;display:inline-block' src="{{ asset('img/logos/1.png') }}">
	@else
	<h1 id='locName'>{{access()->user()->locatario->fantasia}}</h1>
	@endif
	<hr>
    @yield('content')
    <img class='s4w' src="{{ asset('img/logo-Steel4web-600.png') }}">
    <span class="date">Data: {!! date('d/m/Y'); !!}</span>
    
</body>
</html>