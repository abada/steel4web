@if ( !Auth::guest())

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

            @if( Module::has('Importador') )
                <li class="{{ (Request::is(Module::find('Importador')->getLowerName() . '*')) ? 'active' : ''}}">
                    <a href="{{ url('importador') }}"><i class="fa fa-upload fa-fw"></i> Importador</a>
                </li>
            @endif

            @if( Module::has('GestorDeLotes') )
                <li class="{{ (Request::is(Module::find('GestorDeLotes')->getLowerName() . '*')) ? 'active' : ''}}">
                    <a href="{{ url('gestordelotes') }}"><i class="fa fa-th fa-fw"></i> Gestor de Lotes</a>
                </li>
            @endif

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

@endif