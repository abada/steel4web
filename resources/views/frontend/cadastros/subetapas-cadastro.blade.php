@extends('frontend.layouts.master')

<?php
if (isset($edicao)) {
    $name   = 'form-subetapa-edita';
    $action = "update";
    $title  = 'Edição';
} else {
    $name = 'form-subetapa';
    $action = "gravar";
    $title = 'Cadastro';
}
?>
@section('content')
@if(!isset($edicao))
{!! Breadcrumbs::render('Cadastros::subetapa.cadastro',$etapa->obra->nome, $etapa->id, $etapa->codigo, $etapa->obra_id) !!}
@else
{!! Breadcrumbs::render('Cadastros::subetapa.editar', $subetapa->etapa->obra->nome, $subetapa->etapa_id, $subetapa->etapa->codigo, $subetapa->etapa->obra_id, $subetapa->id) !!}
@endif
    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-padrao">
                <div class="panel-heading">
                    <?=$title;?> de subetapa
                </div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-lg-12">
                            <form role="form" name="<?=$name;?>" id="<?=$name;?>" accept-charset="utf-8">
                                <div class="form-group">
                                    <label>Código da Subetapa:</label>
                                    <input class="form-control" name="codigoSubetapa" id="codigoSubetapa" <?php if (isset($edicao)) echo 'value="' . $subetapa->cod . '"' ?>>
                                </div>
                                <div class="form-group">
                                    <label>Peso(KG):</label>
                                    <input class="form-control" name="peso" id="peso" <?php if (isset($edicao)) echo 'value="' . $subetapa->peso . '"' ?>>
                                </div>

                                <div class="form-group">
                                    <label>Tipo da Etapa:</label>
                                    <select class="form-control" name="tipo" id="tipo">
                                        <option>Selecione...</option>
                                    @foreach($tipos as $tipo)
                                        <option value='{{$tipo->id}}' <?php if (isset($edicao)){
                                            if($tipo->id == $subetapa->tipo->id)
                                                echo 'selected';
                                        }

                                         ?>>{{$tipo->descricao}}</option>
                                    @endforeach   
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Observação:</label>
                                    <textarea class="form-control" rows="3" id="observacao" name="observacao"><?php if (isset($edicao) && $subetapa->observacao != '') echo $subetapa->observacao;?></textarea>
                                </div>


                                <?php if (isset($edicao)) { ?>
                                <input type="hidden" name="subetapaID" id="subetapaID" value="<?=$subetapa->id;?>">
                                <?php } ?>
                                <input type="hidden" name="etapaID" id="etapaID" value="<?=$etapaID;?>">


                                <button type="submit" class="btn btn-primary btn-block">Gravar</button>

                            </form>
                        </div>

                        <!-- /.col-lg-6 (nested) -->

                    </div>
                   
                    
                    <!-- /.row (nested) -->
                </div>

                <!-- /.panel-body -->
            </div>
             <div class="row">
                        <div class="col-lg-12">
                            <?php if(isset($edicao)) $tourl =  $subetapa->etapa->obra_id; else $tourl = $obraID; ?>
                        <a href="{{ url('obra/'.$tourl.'#etapas') }}" type="button" class="btn btn-primary"><< Voltar</a>
                        <a href="{{ url('subetapa/tipos') }}" type="button" style='float:right' class="btn btn-primary">Tipos de Subetapas</a>
                    </div>
                    </div>
            <!-- /.panel -->
        </div>
         <div class="col-lg-4 hidden" id="tipoLoading" style="margin-top:20px;background:rgba(0,0,0,0)">
             {{ Html::image('img/ajax-loader.gif', 'Loading...', array('class' => 'lodImg')) }}
        </div>
        <div class="col-lg-4 hidden" id="tipoSuccess">
            <div class="panel panel-green">
                <div class="panel-heading">
                    Gravado com sucesso!
                </div>
                <div class="panel-body">
                    <p>A Subetapa foi gravada com sucesso e já pode ser utilizada!</p>
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
                    <p>A Subetapa não pôde ser gravada, tente novamente mais tarde!</p>
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
                    <p>A Subetapa não pôde ser gravado, Verifique os Campos!</p>
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>
    </div>
@endsection

@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/tabel.js') !!}

@endsection