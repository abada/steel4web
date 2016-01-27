<!doctype html>
<html  lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{{ asset('img/steel4web.ico') }}}">

        <title>@yield('title', 'Steel4Web')</title>

        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'Default Description')">
        <meta name="author" content="@yield('meta_author', 'System3D')">
        <meta name="_token" content="{{ csrf_token() }}" />

    </script>
        @yield('meta')

        <!-- Styles -->

        @yield('before-styles-end')

        {!! Html::style(elixir('css/backend.css')) !!}
        {!! Html::style(elixir('css/frontend.css')) !!}
    
     <!--   <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/> -->
        {{HTML::style('css/bootstrap-editable.css')}}
        {{HTML::style('css/frontend/dataTables.min.css')}}
        {{HTML::style('css/frontend/custom.css')}}
        @yield('after-styles-end')


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-{!! config('backend.theme') !!}">
    <div class="wrapper">
        @include('backend.includes.header')
        @include('backend.includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('page-header')

                {{-- Change to Breadcrumbs::render() if you want it to error to remind you to create the breadcrumbs for the given route --}}
                {!! Breadcrumbs::renderIfExists() !!}
            </section>

            <!-- Main content -->
            <section class="content">
                @include('includes.partials.messages')
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        @include('backend.includes.footer')
    </div><!-- ./wrapper -->

    <!-- JavaScripts -->
 <!--   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->

    <script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery/jquery-2.1.4.min.js')}}"><\/script>')</script>
    <script type="text/javascript"> $(document).ready(function () { $('.dropdown-toggle').dropdown(); }); </script>
     {!! Html::script('js/vendor/dataTables.min.js') !!}
    {!! Html::script('js/vendor/bootstrap/bootstrap.min.js') !!}
   
    @yield('before-scripts-end')
    
    {!! HTML::script(elixir('js/backend.js')) !!}

    @yield('after-scripts-end')
     
   
 <!--   <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script> -->
    {!! Html::script('js/bootstrap-editable.min.js') !!}
    {!! Html::script('js/vendor/funcoes.js') !!}
    {!! Html::script('js/vendor/jquery.mask.min.js') !!}
    {!! Html::script('js/vendor/moment.js') !!}
    {!! Html::script('js/vendor/tabel.js') !!}

    </body>
</html>