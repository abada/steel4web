@extends('frontend.layouts.master')
<?php  
$name_s = 'Categoria de Contato';
$gend = 'a';
if(isset($edicao)){
    $name = 'form-tipo-edita';
    $tipe = 'Editar';
    $type = 'contato';

}else{
    $name = 'form-tipo';
    $tipe = 'Cadastrar';
    $type = 'contato';
}
    if(isset($sub)){
        $name = 'form-tipo-sub';
        $name_s = 'Tipo de Subetapa';
        $type = 'subetapa';
        $gend = 'o';
    }
    if(isset($sub) && isset($edicao)){
        $name = 'form-tipo-sub-edita';
    }
?>

@section('content')
@if(!isset($sub))
@if(isset($edicao))
{!! Breadcrumbs::render('Cadastros::contato.tipo.editar', $tipo->id) !!}
@else
{!! Breadcrumbs::render('Cadastros::contato.tipo.cadastro') !!}
@endif
@else
@if(isset($edicao))
{!! Breadcrumbs::render('Cadastros::subetapa.tipo.editar', $tipo->id) !!}
@else
{!! Breadcrumbs::render('Cadastros::subetapa.tipo.cadastro') !!}
@endif
@endif
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading bg-padrao">
                    {{ $tipe }} {{$name_s}}
                </div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-lg-12">
                            <form role="form" name="<?=$name;?>" id="<?=$name;?>" accept-charset="utf-8">
                                <div class="form-group">
                                    <label>Descricao:</label>
                                    <input class="form-control" name="descricao" id="descricao" <?php if (isset($edicao)) echo 'value="' . $tipo->descricao . '"' ?>>
                                </div>

                                <?php if (isset($edicao)){ ?>
                                <input type="hidden" name="id" id="id" value="{{$tipo->id}}">
                                <?php } ?>
                                <?php if (isset($disable)) { ?>
                                <a href="{{ url('tipo/editar/'.$tipo->id) }}" type="button" class="btn btn-primary btn-block">Editar</a>
                                <?php } else { ?>
                                <button type="submit" class="btn btn-primary btn-block">Gravar</button>
                                <?php } ?>

                            </form>
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
                    <p>{{ucfirst($gend)}} {{$name_s}} foi gravad{{$gend}} com sucesso e já pode ser utilizad{{$gend}}!</p>
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
                    <p>{{ucfirst($gend)}} {{$name_s}} não pôde ser gravad{{$gend}}, tente novamente mais tarde!</p>
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
                    <p>{{ucfirst($gend)}} {{$name_s}} não pôde ser gravad{{$gend}}, possivelmente já existe!</p>
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-6 text-left">
                    <a href="{{ url($type.'/tipos') }}" type="button" class="btn btn-primary"><< Voltar</a>
                </div>
            </div>
        </div>
    </div>
    

@endsection

@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/tabel.js') !!}

@endsection