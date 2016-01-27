<header class="header">
	<a class="logo" href="{{ route('frontend.index') }}">
		<img src="{{ asset('img/logo-Steel4web.png') }}" alt="Steel4Web">
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		@if ( ! Auth::guest())
			<!-- Sidebar toggle button-->
			<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
		@endif
		<div class="navbar-right">
			<ul class="nav navbar-nav">
				@if (Auth::guest())
                    <li>{!! link_to('login', trans('navs.frontend.login')) !!}</li>
                    <li>{!! link_to('register', trans('navs.frontend.register')) !!}</li>
                @else
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
							<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="{!! route('frontend.user.dashboard') !!}"><i class="fa fa-user fa-fw"></i> Perfil</a></li>

							@if (access()->user()->canChangePassword())
								<li><a href="{!! route('auth.password.change') !!}"><i class="fa fa-key fa-fw"></i> Aterar senha</a></li>
							@endif

							@permission('view-backend')
								<li><a href="{!! route('admin.dashboard') !!}">Administração</a></li>
							@endauth

							<li class="divider"></li>
							<li><a href="{!! route('auth.logout') !!}"><i class="fa fa-sign-out fa-fw"></i> Sair</a></li>
						</ul>
						<!-- /.dropdown-user -->
					</li>
				@endif
			</ul>
		</div>
	</nav>
</header>