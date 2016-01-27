<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Steel4Web | Garcia</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="Developed By Luciano Tonet">
    <meta name="keywords" content="Bootstrap 3, Laravel 5.1, Responsive">
    <!-- bootstrap 3.3.6 -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- font Awesome -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Morris chart -->
    <link href="{{ asset('css/morris/morris.css') }}" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="{{ asset('css/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="{{ asset('css/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <!-- fullCalendar -->
    <!-- <link href="{{ asset('css/fullcalendar/fullcalendar.css') }}" rel="stylesheet" type="text/css" /> -->
    <!-- Daterange picker -->
    <link href="{{ asset('css/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="{{ asset('css/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="{{ asset('css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />

    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>

    <!-- Bootstrap Select -->
    <link href="{{ asset('css/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- DATATABLES -->
    {{-- <link rel="stylesheet" href="{{ asset('css/datatables/jquery.dataTables.min.css') }}"> --}}
    <!-- DATATABLES BOOTSTRAP CSS-->
    <link rel="stylesheet" href="{{ asset('css/datatables/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables/select.dataTables.min.css') }}">

    <!-- Theme style -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom styles -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->

</head>
<body class="skin-black">

    <header class="header">
        <a class="logo" href="http://steel4web.com.br/new_s4w/saas/admin">
            <img src="http://steel4web.com.br/new_s4w/assets/img/logo-Steel4web.png" alt="Stell4Web">
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="http://steel4web.com.br/new_s4w/saas/profile/ver"><i class="fa fa-user fa-fw"></i> Perfil do usuário</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="http://steel4web.com.br/new_s4w/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="wrapper row-offcanvas row-offcanvas-left">

        <aside class="left-side sidebar-offcanvas">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="nav in sidebar-menu" id="side-menu">
                    <li>
                        <a href="http://steel4web.com.br/new_s4w/saas/admin" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="http://steel4web.com.br/new_s4w/saas/clientes/listar"><i class="fa fa-users fa-fw"></i> Clientes</a>
                    </li>
                    <li>
                        <a href="http://steel4web.com.br/new_s4w/saas/obras/listar"><i class="fa fa-building-o fa-fw"></i> Obras</a>
                    </li>
                    <li>
                        <a href="http://steel4web.com.br/new_s4w/saas/contatos/listar"><i class="fa fa-phone fa-fw"></i> Contatos</a>
                    </li>
                    <li>
                        <a href="http://steel4web.com.br/new_s4w/saas/usuarios/listar"><i class="fa fa-user fa-fw"></i> Usuários</a>
                    </li>
                    <li class="active">
                        <a href="http://steel4web.com.br/dev/gestor-de-lotes/public/lotes"><i class="fa fa-home fa-fw"></i> Gestor de Lotes</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-print fa-fw"></i> Relatórios</a>
                    </li>
                                    <li>
                        <a href="http://steel4web.com.br/new_s4w/saas/logs/listar"><i class="fa fa-eye fa-fw"></i> Logs</a>
                    </li>
                </ul>

            </section>
            <!-- /.sidebar -->
        </aside>

        <aside class="right-side">

            <!-- Main content -->
            <section class="content">

                <!-- System Notifications -->
                @if(Session::has('sys_notifications'))
                <div class="alert-group">
                    @foreach ( Session::get('sys_notifications') as $sys_notification )
                    <div class="alert alert-{!! $sys_notification['type'] or 'info' !!}">
                        @if ( !@$sys_notification['important'] )
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        @endif
                        {!! $sys_notification['message'] !!}
                    </div>
                    @endforeach
                </div>
                @endif
                <!-- /System Notifications -->

                <!-- MAIN CONTENT -->
                @yield('content')
                <!-- /MAIN CONTENT -->

                @include('templates.modal')

            </section><!-- /.content -->

            <div class="footer-main">
                <small>Steel4Web | Copyright &copy Garcia, <?php echo date('Y') ?></small>
            </div>

        </aside><!-- /.right-side -->

    </div><!-- ./wrapper -->


    <!-- MODAL -->
    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>

    @include('templates.scripts')

</body>
</html>