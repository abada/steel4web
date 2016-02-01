@extends('frontend.layouts.master')

@section('content')
   <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{count($dados->clientes)}}</div>
                            <div>Clientes cadastrados</div>
                        </div>
                    </div>
                </div>
                <div class="panel-list">
                    @if(count($dados->clientes)>0)
                        @foreach($dados->clientes as $cliente)
                        <a href="{{ url('cliente/'.$cliente->id) }}">{{$cliente->razao}}</a>
                        @endforeach
                    @else
                        <span>Nenhum Cliente Cadastrado.</span>
                    @endif
                </div>
                <a href="{{ url('clientes') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Ver todos</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-building-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{count($dados->obras)}}</div>
                            <div>Obras cadastradas</div>
                        </div>
                    </div>
                </div>
                <div class="panel-list">
                    @if(count($dados->obras)>0)
                        @foreach($dados->obras as $obra)
                        <a href="{{ url('obra/'.$obra->id) }}">{{$obra->nome}}</a>
                        @endforeach
                    @else
                        <span>Nenhuma Obra Cadastrado.</span>
                    @endif
                </div>
                <a href="{{ url('obras') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Ver todas</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
         <div class="col-lg-4 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{count($dados->users)}}</div>
                            <div>Usuarios Cadastrados</div>
                        </div>
                    </div>
                </div>
                <div class="panel-list">
                    @if(count($dados->users)>0)
                        @foreach($dados->users as $user)
                        <a href="{{ url('admin/access/users/'.$user->id.'/edit') }}">{{$user->name}}</a>
                        @endforeach
                    @else
                        <span>Nenhuma Obra Cadastrado.</span>
                    @endif
                </div>
                <a href="{{ url('admin/access/users') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Ver todos</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/tabel.js') !!}

@endsection