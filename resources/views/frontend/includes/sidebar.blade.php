<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                @if(!empty(access()->user()->image->image))
                  <img src="{{route('file_preview', access()->user()->image->id)}}" class='img-circle' alt='Imagem de Usuario'>
                  @else
                  {{ Html::image('img/avatar.png', 'User Image', array('class' => 'img-circle')) }}
                  @endif
            </div>
            <div class="pull-left info">
                <p> @if(access()->user())
                      {{access()->user()->name}}
                      @endif</p>
                      
                <a href="#"><i class="fa fa-circle text-success"></i> {{access()->user()->roles->first()->name}}</a>

            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header"></li>
            <!-- <li class="header">MAIN NAVIGATION</li> -->
            <li class="{{ Active::pattern('/') }}">
                <a href="{{ url('/') }}"><i class="fa fa-dashboard fa-fw"></i><span> Painel de Controle</span></a>
            </li>
            <li class="header">Módulos</li>
            @if( Module::has('Importador') )
            @permission('visualizar-importador','criar-importacao','deletar-importacao')
            <li class="{{ (Request::is(Module::find('Importador')->getLowerName() . '*')) ? 'active' : ''}}">
                <a href="{{ url('importador') }}"><i class="fa fa-upload fa-fw"></i> Importador</a>
            </li>
            @endauth
            @endif

            @if( Module::has('GestorDeLotes') )
            @permission('visualizar-apontador', 'criar-apontacao')
            <li class="{{ (Request::is(Module::find('GestorDeLotes')->getLowerName() . '*')) ? 'active' : ''}}">
                <a href="{{ url('gestordelotes') }}"><i class="fa fa-th fa-fw"></i> Gestor de Lotes</a>
            </li>
            @endauth
            @endif

            @if( Module::has('Apontador') )
           @permission('visualizar-gestor', 'criar-lotes', 'editar-lotes')
            <li class="{{ (Request::is(Module::find('Apontador')->getLowerName() . '*')) ? 'active' : ''}}">
                <a href="{{ url('apontador') }}"><i class="fa fa-hand-pointer-o fa-fw"></i> Apontador</a>
            </li>
            @endauth
            @endif

            @if( Module::has('Romaneios') )
           @permission('visualizar-gestor', 'criar-lotes', 'editar-lotes')
            <li class="{{ (Request::is(Module::find('Romaneios')->getLowerName() . '*')) ? 'active' : ''}}">
                <a href="{{ url('romaneios') }}"><i class="fa fa-truck fa-fw"></i> Romaneios</a>
            </li>
            @endauth
            @endif

           @permission('ver-cadastro', 'criar-cadastro', 'deletar-cadastro', 'editar-cadastro')
            <li class="header">Cadastros</li>
            <li class="{{ Active::pattern('clientes') }} {{ Active::pattern('cliente/*') }}">
                <a href="{!! route('clientes') !!}"><i class="fa fa-users fa-fw"></i><span> Clientes</span></a>
            </li>
            <li class="{{ Active::pattern('obras') }} {{ Active::pattern('obra/*') }} {{ Active::pattern('etapa/*') }} {{ Active::pattern('subetapa/*') }}">
                <a href="{!! route('obras') !!}"><i class="fa fa-building-o fa-fw"></i><span> Obras</span></a>
            </li>
            <li class="{{ Active::pattern('contatos') }} {{ Active::pattern('contato/*') }} {{ Active::pattern('tipo/*') }}">
                <a href="{!! route('contatos') !!}"><i class="fa fa-phone fa-fw"></i><span> Contatos</span></a>
            </li>
            @endauth
            @if (access()->hasRole(1))
            <li class="{{ Active::pattern('admin/access/*') }}">
                <a href="{!!url('admin/access/users')!!}"><i class="fa fa-user fa-fw"></i><span> Usuários</span></a>
            </li> 
            @endif

             </ul>
    </section>
    <!-- /.sidebar -->
</aside>

         <!--   <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Layout Options</span>
                    <span class="label label-primary pull-right">4</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                    <li><a href="../layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                    <li><a href="../layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                    <li><a href="../layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                </ul>
            </li>
            <li>
                <a href="../widgets.html">
                    <i class="fa fa-th"></i> <span>Widgets</span> <small class="label pull-right bg-green">Hot</small>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Charts</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                    <li><a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                    <li><a href="../charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                    <li><a href="../charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>UI Elements</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
                    <li><a href="../UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                    <li><a href="../UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                    <li><a href="../UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                    <li><a href="../UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                    <li><a href="../UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Forms</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                    <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                    <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table"></i> <span>Tables</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                    <li><a href="../tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
                </ul>
            </li>
            <li>
                <a href="../calendar.html">
                    <i class="fa fa-calendar"></i> <span>Calendar</span>
                    <small class="label pull-right bg-red">3</small>
                </a>
            </li>
            <li>
                <a href="../mailbox/mailbox.html">
                    <i class="fa fa-envelope"></i> <span>Mailbox</span>
                    <small class="label pull-right bg-yellow">12</small>
                </a>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Examples</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                    <li><a href="profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                    <li><a href="login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                    <li><a href="register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                    <li><a href="lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                    <li><a href="404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                    <li><a href="500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                    <li class="active"><a href="blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Multilevel</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                            <li>
                                <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                </ul>
            </li>
            <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
