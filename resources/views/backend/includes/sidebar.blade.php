<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{!! access()->user()->picture !!}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{!! access()->user()->name !!}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> online </a>
            </div>
        </div>

        <!-- search form (Optional) 
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('strings.backend.general.search_placeholder') }}"/>
                  <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
            </div>
        </form>
         /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <br>

            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Active::pattern('admin/dashboard') }}">
                <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-dashboard fa-fw"></i><span> Painel de Controle</span></a>
            </li>
            <li class="{{ Active::pattern('admin/lo') }}">
                <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-users fa-fw"></i><span> Clientes</span></a>
            </li>
            <li class="{{ Active::pattern('obras') }}">
                <a href="{!! route('obras') !!}"><i class="fa fa-building-o fa-fw"></i><span> Obras</span></a>
            </li>
            <li class="{{ Active::pattern('admin/lo') }}">
                <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-phone fa-fw"></i><span> Contatos</span></a>
            </li>
            <li class="{{ Active::pattern('admin/lo') }}">
                <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-user fa-fw"></i><span> Usuários</span></a>
            </li>
            <li class="{{ Active::pattern('admin/lo') }}">
                <a href="http://steel4web.com.br/dev/gestor-de-lotes/public/lotes"><i class="fa fa-home fa-fw"></i><span> Gestor de Lotes</span></a>
            </li>
            <li class="{{ Active::pattern('admin/lo') }}">
                <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-eye fa-fw"></i><span> Logs</span></a>
            </li>

      <!--       @permission('view-access-management')
                <li class="{{ Active::pattern('admin/access/*') }}">
                    <a href="{!!url('admin/access/users')!!}"><span>{{ trans('menus.backend.access.title') }}</span></a>
                </li>
            @endauth

           <li class="{{ Active::pattern('admin/log-viewer*') }} treeview">
                <a href="#">
                    <span>{{ trans('menus.backend.log-viewer.main') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ Active::pattern('admin/log-viewer*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/log-viewer*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/log-viewer') }}">
                        <a href="{!! url('admin/log-viewer') !!}">{{ trans('menus.backend.log-viewer.dashboard') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/log-viewer/logs') }}">
                        <a href="{!! url('admin/log-viewer/logs') !!}">{{ trans('menus.backend.log-viewer.logs') }}</a>
                    </li>
                </ul>
            </li> -->

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>