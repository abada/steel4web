<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', app_name())</title>
    {{Html::style('css/pdf.css')}}
</head>
<body>
	<div class="header">
		<span class='pagina'>Página <span class="pagenum"></span></span>
		@if(!empty(access()->user()->locatario->logo))
		<img class='locatarioLogoImg' src="{{ asset('img/logos/1.png') }}">
		@else
		<h1 id='locName'>{{access()->user()->locatario->fantasia}}</h1>
		@endif
	</div>
	<div class="footer">
		<img class='s4w' src="{{ asset('img/logo-Steel4web-600.png') }}">
    <span class="date">Data: {!! date('d/m/Y'); !!}</span>
	</div>
	<header style='width:60%;display:inline-block'>@yield('header')</header>
	
	<hr>
    @yield('content')
    
    
</body>
</html>