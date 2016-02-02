@extends('frontend.layouts.master')
<?php 
    if(isset($sub)){
        $name = 'Tipos de Subetapas';
        $name_s = 'Tipo de Subetapa';
        $type = 'subetapa';
    }else{
        $name = 'Categorias de Contatos';
        $name_s = 'Categoria de Contato';
        $type = 'contato';
    }
 ?>
@section('content')
@if(!isset($sub))
{!! Breadcrumbs::render('Cadastros::contato.tipos') !!}
@else
{!! Breadcrumbs::render('Cadastros::subetapa.tipos') !!}
@endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading bg-padrao">
                    Listagem de {{$name}}
                   
                </div>
                @if(!empty($tipos))
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered  dt-responsive nowrap table-hover dataTables" cellspacing="0" width="100%" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th width="10%">Data</th>
                                    <th width="10%">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($tipos as $tipo)
                                <tr class="stripped">
                                    <td>{{$tipo->descricao}}</td>
                                    <td>{{ date('d/m/Y', strtotime($tipo->created_at)) }}</td>
                                     <td>
                                        <div class="text-center">
                                            <a href="{{ url($type.'/tipo/editar/'.$tipo->id) }}" alt="Editar {{$name_s}}" title="Editar {{$name_s}}">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                            <a href="{{ url($type.'/tipo/excluir/'.$tipo->id) }}" alt="Excluir {{$name_s}}" title="Excluir {{$name_s}}">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.panel-body -->
                @else
                <div class="panel-heading">
                    <h4>Nada ainda cadastrado!</h4>
                </div>
                @endif
            </div>
            <!-- /.panel -->


        </div>
        <!-- /.col-lg-12 -->
        @if(!isset($sub))
        <div class="col-lg-6 col-md-6">
            <a href="{{ url('contatos') }}" type="button" class="btn btn-primary"><< Voltar</a>
        </div>
        @else
        <div class="col-lg-6 col-md-6">
            <a href="javascript:history.back()" type="button" class="btn btn-primary"><< Voltar</a>
        </div>
        @endif
        <div class="col-lg-6 col-md-6 text-right">
           <a href="{{ url($type.'/tipo/cadastro') }}" type="button" class="btn btn-primary">Cadastrar {{$name_s}}</a>
        </div>
        
    </div>

@endsection

@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/tabel.js') !!}

@endsection