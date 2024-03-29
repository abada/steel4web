@extends('frontend.layouts.master')
<?php 
    if(isset($contato)){
        $name = 'Contatos';
        $nome2 = 'Contato';
        $type = 'contato';
    }else{
        $name = 'Clientes';
        $nome2 = 'Cliente';
        $type = 'cliente';
    }
 ?>

@section('content')
@if(isset($contato))
{!! Breadcrumbs::render('Cadastros::contatos') !!}
@else
{!! Breadcrumbs::render('Cadastros::clientes') !!}
@endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading bg-padrao">
                    Listagem de {{$name}}
                   
                </div>
                <?php if (!empty($clientes)) { ?>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered  dt-responsive nowrap table-hover dataTables" cellspacing="0" width="100%" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Razão Social</th>
                                    <th>Fantasia</th>
                                    <th width="15%">Telefone</th>
                                    <th width="10%">Tipo</th>
                                    <th width="10%">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($clientes as $cliente) {
                                if(!isset($contato)){
                                    if ($cliente->tipo == 1) {
                                        $tip = 'Física';
                                    } else {
                                        $tip = 'Jurídico';
                                    } 
                                }else{
                                    $tip = isset($cliente->tipo->descricao) ? $cliente->tipo->descricao : '-';
                                }
                                ?>
                                <tr class="stripped">
                                    <td>
                                    @if(!isset($contato))
                                    <a href="{{ url($type.'/'.$cliente->id) }}"><?=$cliente->razao;?></a>
                                    @else
                                        @if(!empty($cliente->razao))
                                          <a href="{{ url($type.'/'.$cliente->id) }}">{{$cliente->razao}}</a>
                                        @else
                                         -
                                        @endif
                                    @endif
                                    </td>
                                    <td>
                                    @if(isset($contato) && empty($cliente->razao))
                                    <a href="{{ url($type.'/'.$cliente->id) }}">
                                    @endif
                                        <?php if(isset($cliente->fantasia)) echo $cliente->fantasia; ?>
                                    @if(isset($contato))
                                    </a>
                                    @endif
                                    </td>
                                    <td class="telefone"><?php if(isset($cliente->fone)) echo $cliente->fone;?></td>
                                    <td class="text-center"><?=$tip;?></td>
                                     <td>
                                        <div class="text-center">
                                            <a href="{{ url($type.'/editar/'.$cliente->id) }}" alt="Editar {{$type}}" title="Editar {{$type}}">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                            @if (access()->hasRole(1))
                                            @if(!isset($contato))
                                            <a href="{{url('cliente/excluir/'.$cliente->id)}}" alt="Excluir Cliente" title="Excluir Cliente" style="text-decoration:none">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                            @else
                                            <a href="{{url('contato/excluir/'.$cliente->id)}}" alt="Excluir Contato" title="Excluir Contato" style="text-decoration:none">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                            @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.panel-body -->
                <?php } else { ?>
                <div class="panel-heading">
                    <h4>Nada ainda cadastrado!</h4>
                </div>
                <?php } ?>
            </div>
            <!-- /.panel -->

              


        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-6 col-md-6">
            <a href="javascript:history.back()" type="button" class="btn btn-primary"><< Voltar</a>
        </div>
        <div class="col-lg-6 col-md-6 text-right">
             @if(isset($contato))
            <a href="{{ url('contato/tipos') }}" type="button" class="btn btn-primary">Tipos de Contatos</a>
             @endif
           <a href="{{ url($type.'/cadastro') }}" type="button" class="btn btn-primary">Cadastrar {{$nome2}}</a>
        </div>
    </div>
@endsection

@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/tabel.js') !!}

@endsection