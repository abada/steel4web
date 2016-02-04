<header class="main-header">
        <!-- Logo -->
        <a href="{{ route('/') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">

        <img src="{{ asset('img/logo-Steel4web.png') }}" alt="Steel4Web">
    </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  {{ Html::image('img/avatar.png', 'User Image', array('class' => 'user-image')) }}
                  <span class="hidden-xs">
                     @if(access()->user())
                      {{access()->user()->name}}
                      @endif
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    {{ Html::image('img/avatar.png', 'User Image', array('class' => 'img-circle')) }}
                    <p>
                      @if(access()->user())
                      {{access()->user()->name}}
                      @endif

                      <small>{{access()->user()->locatario->razao}}</small>
                    </p>
                  </li>
                  <!-- Menu Body -->

                  <li class="user-body">
                    <div class="col-xs-12 text-center">
                      @if(access()->user())
                        @if (access()->user()->canChangePassword())
                          <a href="{!! route('auth.password.change') !!}"><i class="fa fa-key fa-fw"></i> Aterar senha</a>
                        @endif
                      @endif
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{!! route('frontend.user.dashboard') !!}" class="btn btn-default btn-flat"><i class="fa fa-user fa-fw"></i> Perfil</a>
                    </div>
                    <div class="pull-right">
                      <a href="{!! route('auth.logout') !!}" class="btn btn-default btn-flat"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li> -->
            </ul>
          </div>
        </nav>
      </header>