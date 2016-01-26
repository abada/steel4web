@extends('backend.layouts.master')

@section('page-header')
<div class="row">
    <div class="col-lg-8">
         <h3>
        Categoria de Contatos
        </h3>
    </div>
    <div class="col-lg-4">
         @if(Session::has('success'))
        <div class="panel panel-green">
            <div class="panel-heading"> 
                Sucesso!
            <div class="closePanel"><i class="fa fa-times"></i></div>
            </div>
            <div class="panel-body">
                {{Session::get('success')}}
            </div>
        </div>
    @elseif(Session::has('error'))
        <div class="panel panel-red">
            <div class="panel-heading"> 
                Error!
                <div class="closePanel"><i class="fa fa-times"></i></div>
            </div>
            <div class="panel-body">
                {{Session::get('error')}}
            </div>
        </div>
    @endif
    </div>
</div>
   
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading bg-navy">
                    Listagem de Categoria de Contatos
                   
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
                                            <a href="../tipo/editar/{{$tipo->id}}" alt="Editar Categoria de Contato" title="Editar Categoria de Contato">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                            <a href="../tipo/excluir/{{$tipo->id}}" alt="Excluir Categoria de Contato" title="Excluir Categoria de Contato">
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
        <div class="col-lg-6 col-md-6">
            <a href="javascript:history.back()" type="button" class="btn btn-primary"><< Voltar</a>
        </div>
        <div class="col-lg-6 col-md-6 text-right">
           <a href="../tipo/cadastro" type="button" class="btn btn-primary">Cadastrar Categoria de Contato</a>
        </div>
    </div>

@endsection