@extends('frontend.layouts.master')

@section('page-header')
    <h1>
        Steel4Web
        <small>Painel de Controle Administrativo</small>
    </h1>
@endsection

@section('content')
   <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">5</div>
                            <div>Clientes cadastrados</div>
                        </div>
                    </div>
                </div>
                <div class="panel-list">
                   <span>Nenhum Cliente Cadastrado.</span>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Ver todos</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-building-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">0</div>
                            <div>Obras cadastradas</div>
                        </div>
                    </div>
                </div>
                <div class="panel-list">
                    <span>Nenhuma Obra Cadastrada.</span>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Ver todas</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
         <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">0</div>
                            <div>Usuarios Cadastrados</div>
                        </div>
                    </div>
                </div>
                <div class="panel-list">
                    <span>Nenhum Usuario Cadastrado.</span>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Ver todos</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-upload fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">0</div>
                            <div>Importações Cadastradas</div>
                        </div>
                    </div>
                </div>
                 <div class="panel-list">
                  <span>Nenhuma Importação Cadastrada.</span>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Ver todas</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection