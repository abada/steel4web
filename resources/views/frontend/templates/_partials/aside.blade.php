<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">


    <section class="sidebar">
        <!-- Sidebar user panel -->

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">

            <li class="{{ Request::is('lotes*') ? 'active' : '' }}">
                <a href="{!! url('/lotes') !!}">
                    <i class="fa fa-th"></i> <span>Gestor de Lotes</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->

</aside>