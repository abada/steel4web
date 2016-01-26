@extends('backend.layouts.master')
@section('page-header')
<?php
if (isset($edicao)) {
    $name  = 'form-obra-edita';
    $title = 'Edição';
} else {
    $name = 'form-obra';
    $title = 'Cadastro';
}
?>
    <h1>
       <?=$title;?> de Obra
    </h1>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading bg-navy">
                    <?=$title;?> de obra
                </div>
                <div class="panel-body">
                    <form role="form" name="<?=$name;?>" id="<?=$name;?>" accept-charset="utf-8">
                    <div class="row">
                            <div class="col-lg-6">
                               @foreach($tipos as $tipo)
                                @if(in_array($tipo->id, $selIds))
                                <div class="form-group">
                                    <label>{{$tipo->descricao}}:</label>
                                    <select class="form-control" name="{{$tipo->id}}X95c55e5759335f81907e08fe999ed1f8X" id="{{$tipo->id}}">
                                        <option>Selecione...</option>
                                        @foreach($contatos as $contato)
                                            @if(isset($contato->tipo->id))
                                                @if($contato->tipo->id == $tipo->id)
                                              <option value="{{$contato->id}}" 
                                            <?php if(isset($edicao)){
                                                foreach($sel as $ceu){
                                                    if($ceu->id == $contato->id && $ceu->tipo->id == $tipo->id){
                                                        echo 'selected';
                                                    }
                                                }
                                              }?>>
                                                @if(!empty($contato->razao))
                                                    {{$contato->razao}}
                                                @else
                                                    {{$contato->fantasia}}
                                                @endif
                                              </option>;
                                              @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                    @endif
                                @endforeach

                                <?php if (isset($edicao)) { ?>
                                <input type="hidden" name="obraID" id="obraID" value="<?=$obra->id;?>">
                                <?php } ?>

                               

                            </form>
                        </div>
                          <div class="col-lg-6">
                            
                                <div class="form-group">
                                    <label>Código da Obra <i style='color:red'>*</i> :</label>
                                    <input class="form-control" name="codigo" id="codigo" <?php if (isset($edicao)) echo 'value="' . $obra->codigo . '"' ?>>
                                </div>
                                <div class="form-group">
                                    <label>Nome da Obra <i style='color:red'>*</i> :</label>
                                    <input class="form-control" name="nome" id="nome" <?php if (isset($edicao)) echo 'value="' . $obra->nome . '"' ?>>
                                </div>
                                
                                  <div class="form-group">
                                    <label>Cliente <i style='color:red'>*</i> :</label>
                                    <select class="form-control" name="cliente_id" id="clienteID">
                                        <option>Selecione...</option>
                                        <?php foreach ($clientes as $cliente) { ?>
                                        <option value="<?=$cliente->id;?>" <?php if(isset($edicao) && $obra->cliente_id == $cliente->id) echo 'selected'; ?>><?=$cliente->razao;?></option>;
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Descrição <i style='color:red'>*</i> :</label>
                                    <input class="form-control" name="descricao" id="descricao" <?php if (isset($edicao)) echo 'value="' . $obra->descricao . '"' ?>>
                                </div>

                                <div class="form-group">
                                    <label for="cidade">Cidade <i style='color:red'>*</i> :</label>
                                     <input class="form-control" id="cidade" name="cidade" <?php if (isset($edicao)) echo 'value="' . $obra->cidade . '"' ?>>
                                </div>

                                <div class="form-group">
                                    <label>Endereço <i style='color:red'>*</i> :</label>
                                    <input class="form-control" name="endereco" id="endereco" <?php if (isset($edicao)) echo 'value="' . $obra->endereco . '"' ?>>
                                </div>

                                <div class="form-group">
                                    <label>CEP <i style='color:red'>*</i> :</label>
                                    <input class="form-control cep" name="cep" id="cep" <?php if (isset($edicao)) echo 'value="' . $obra->cep . '"' ?>>
                                </div>
                                 <button type="submit" style='margin-top:40px' class="btn btn-primary btn-block">Gravar</button>
                                 <i style='color:red;float:right;margin-right:15px;margin-top:10px'>*<strong style='color:#323232'> Campos Obrigatorios</strong></i>
                            </div>
                        <!-- /.col-lg-12 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-4 -->
        <div class="col-lg-4 hidden" id="tipoLoading" style="margin-top:20px;background:rgba(0,0,0,0)">
              <img style="width:10%;margin-left:45%" src="/img/ajax-loader.gif">
        </div>
        <div class="col-lg-4 hidden" id="tipoSuccess">
            <div class="panel panel-green">
                <div class="panel-heading">
                    Gravado com sucesso!
                </div>
                <div class="panel-body">
                    <p>A obra foi gravada com sucesso!</p>
                </div>
             </div>
            <!-- /.panel -->
        </div>
        <div class="col-lg-4 hidden" id="tipoError">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Erro ao gravar!
                </div>
                <div class="panel-body">
                    <p>A obra não pôde ser gravado, tente novamente mais tarde!</p>
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>
        <div class="col-lg-4 hidden" id="tipoError2">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Erro ao gravar!
                </div>
                <div class="panel-body">
                    <p>A obra não pôde ser gravado, verifique os dados</p>
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>
    </div>
    <a href="javascript:history.back()" type="button" class="btn btn-primary"><< Voltar</a>

@endsection