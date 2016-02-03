@extends('frontend.layouts.master')
<?php
if (isset($edicao)) {
    $name  = 'form-etapa-edita';
    $title = 'Edição';
} else {
    $name = 'form-etapa';
    $title = 'Cadastro';
}
?>
@section('content')
@if(!isset($edicao))
{!! Breadcrumbs::render('Cadastros::etapa.cadastro',$obra->nome, $obra->id) !!}
@else
{!! Breadcrumbs::render('Cadastros::etapa.editar', $etapa->id, $etapa->obra->nome, $etapa->obra_id) !!}
@endif
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading bg-padrao">
                    <?=$title;?> de etapa
                </div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-lg-12">
                            <form role="form" name="<?=$name;?>" id="<?=$name;?>" accept-charset="utf-8">
                                <div class="form-group">
                                    <label>Código da Etapa:</label>
                                    <input class="form-control" name="codigoEtapa" id="codigoEtapa" <?php if (isset($edicao)) echo 'value="' . $etapa->codigo . '"' ?>>
                                </div>
                                <div class="form-group">
                                    <label>Peso:</label>
                                    <input class="form-control" name="peso" id="peso" <?php if (isset($edicao)) echo 'value="' . $etapa->peso . '"' ?>>
                                </div>

                                <div class="form-group">
                                    <label>Observação:</label>
                                    <textarea class="form-control" rows="3" id="observacao" name="observacao"><?php if (isset($edicao) && $etapa->observacao != '') echo $etapa->observacao;?></textarea>
                                </div>


                                <?php if (isset($edicao)) {
                                  $obraID = $etapa->obra_id;
                                 ?>
                                <input type="hidden" name="etapaID" id="etapaID" value="<?=$etapa->id;?>">
                                <input type="hidden" name="obraID" id="obraID" value="<?=$etapa->obra_id;?>">
                                <?php }else{ ?>
                                <input type="hidden" name="obraID" id="obraID" value="<?=$obraID;?>">
                                <?php } ?>

                                <button type="submit" class="btn btn-primary btn-block">Gravar</button>

                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-4 -->
        <div class="col-lg-4 hidden" id="tipoLoading" style="margin-top:20px;background:rgba(0,0,0,0)">
              {{ Html::image('img/ajax-loader.gif', 'Loading...', array('class' => 'lodImg')) }}
        </div>
        <div class="col-lg-4 hidden" id="tipoSuccess">
            <div class="panel panel-green">
                <div class="panel-heading">
                    Gravado com sucesso!
                </div>
                <div class="panel-body">
                    <p>A etapa foi gravada com sucesso!</p>
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
                    <p>A etapa não pôde ser gravado, tente novamente mais tarde!</p>
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
                    <p>A etapa não pôde ser gravado, verifique os dados</p>
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>
    </div>
    <a href="{{ url('obra/'.$obraID.'#etapas') }}" type="button" class="btn btn-primary"><< Voltar</a>
@endsection
@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/tabel.js') !!}

@endsection