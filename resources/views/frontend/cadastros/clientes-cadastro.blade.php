@extends('frontend.layouts.master')

<?php
$name2 = 'Cliente';
if (isset($edicao)) {
    $name = 'form-cliente-edita';
    $tipo = 'Editar';
} else {
    $name = 'form-cliente';
    $tipo = 'Cadastrar';
}
if(isset($contato)){
    $name = 'form-contato';
    $tipo = 'Cadastrar';
    $name2 = 'Contato';
}
if(isset($contato) && isset($edicao)){
     $name = 'form-contato-edita';
    $tipo = 'Editar';
}
if(isset($disable)){
    $tipo = 'Perfil de ';
    $name = '';
}
?>

@section('content')
@if(isset($contato))
@if(!isset($edicao))
{!! Breadcrumbs::render('Cadastros::contato.cadastro') !!}
@elseif(!isset($disable))
{!! Breadcrumbs::render('Cadastros::contato.editar', $cliente->id) !!}
@endif
@if(isset($disable))
{!! Breadcrumbs::render('Cadastros::contato', $cliente->id) !!}
@endif
@else
@if(!isset($edicao))
{!! Breadcrumbs::render('Cadastros::cliente.cadastro') !!}
@elseif(!isset($disable))
{!! Breadcrumbs::render('Cadastros::cliente.editar', $cliente->id) !!}
@endif
@if(isset($disable))
{!! Breadcrumbs::render('Cadastros::cliente', $cliente->id) !!}
@endif
@endif
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading bg-padrao">
                    {{ $tipo }} {{ $name2 }}
                </div>
                <div class="panel-body">
                    <div class="row">

                         <div class="col-lg-6">
                            <form role="form" name="<?=$name;?>" id="<?=$name;?>" accept-charset="utf-8">
                                <div class="form-group">
                                    <label>Razão Social 
                                        <i style='color:red'>*</i>
                                     :</label>
                                    <input class="form-control" name="razao" id="razao" <?php if (isset($edicao)) echo 'value="' . $cliente->razao . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                <div class="form-group">
                                    <label>Nome Fantasia
                                      @if(!isset($contato))
                                        <i style='color:red'>*</i>
                                      @endif
                                      :</label>
                                    <input class="form-control" name="fantasia" id="fantasia" <?php if (isset($edicao)) echo 'value="' . $cliente->fantasia . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                <div class="form-group">
                                    <label>Email <i style='color:red'>*</i> :</label>
                                    <input class="form-control" name="email" id="email" <?php if (isset($edicao)) echo 'value="' . $cliente->email . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                @if(!isset($contato))
                                 <div class="form-group">
                                    <label>Tipo de Cliente <i style='color:red'>*</i> :</label>
                                    <select class="form-control" name="tipo" id="tipo" <?php if (isset($disable)) echo 'disabled'; ?>>
                                        <option value="0" <?php if (isset($edicao) && $cliente->tipo == 0) echo 'selected'; ?>>Físico</option>
                                        <option value="1" <?php if (isset($edicao) && $cliente->tipo == 1) echo 'selected'; ?>>Jurídico</option>
                                    </select>
                                </div>
                                @else
                                    <div class="form-group">
                                    <label>Tipo de Contato <i style='color:red'>*</i> :</label>
                                    <select class="form-control" name="tipo_id" id="tipo_id" <?php if (isset($disable)) echo 'disabled'; ?>>
                                        @foreach($tipos as $Type)
                                        <option value="{{$Type->id}}" <?php if (isset($edicao) && $cliente->tipo_id == $Type->id) echo 'selected'; ?>>{{$Type->descricao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                 <div class="form-group">
                                    <label>Documento 
                                        @if(!isset($contato))
                                        <i style='color:red'>*</i>
                                        @endif
                                         :</label>
                                    <input class="form-control documento" name="documento" id="documento"  <?php if (isset($edicao)) echo 'value="' . $cliente->documento . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                <div class="form-group">
                                    <label>Inscrição Estadual 
                                        @if(!isset($contato))
                                        <i style='color:red'>*</i>
                                        @endif :</label>
                                    <input class="form-control" name="inscricao" id="inscricao"  <?php if (isset($edicao)) echo 'value="' . $cliente->inscricao . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                 <div class="form-group">
                                    <label>Telefone <i style='color:red'>*</i> :</label>
                                    <input class="form-control telefone" name="telefone" id="telefone" <?php if (isset($edicao)) echo 'value="' . $cliente->fone . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                             
                            </div>
                            <!-- /.col-lg-6 (nested) -->
                            <div class="col-lg-6">
                                
                                <div class="form-group">
                                    <label>Cidade <i style='color:red'>*</i> :</label>
                                    <input class="form-control" name="cidade" id="cidade" <?php if (isset($edicao)) echo 'value="' . $cliente->cidade . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>

                                <div class="form-group">
                                    <label>Endereço <i style='color:red'>*</i> :</label>
                                    <input class="form-control" name="endereco" id="endereco" <?php if (isset($edicao)) echo 'value="' . $cliente->endereco . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>

                                <div class="form-group">
                                    <label>CEP <i style='color:red'>*</i> :</label>
                                    <input class="form-control cep" name="cep" id="cep" <?php if (isset($edicao)) echo 'value="' . $cliente->cep . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>

                                <div class="form-group">
                                    <label>Site:</label>
                                    <input class="form-control site" name="site" id="site" <?php if (isset($edicao)) echo 'value="' . $cliente->site . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>

                                <div class="form-group">
                                    <label>Responsavel:</label>
                                    <input class="form-control responsavel" name="responsavel" id="responsavel" <?php if (isset($edicao)) echo 'value="' . $cliente->responsavel . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                @if(isset($contato))
                                <div class="form-group">
                                    <label>CREA:</label>
                                    <input class="form-control crea" name="crea" id="crea" <?php if (isset($edicao)) echo 'value="' . $cliente->crea . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                @endif
                                <?php if (isset($edicao) || isset($disable)){ ?>
                                <input type="hidden" name="id" id="id" value="{{$cliente->id}}">
                                <?php } ?>
                                <?php if (isset($disable) && !isset($contato)) { ?>
                                <a href="{{url ('cliente/editar/'.$cliente->id) }}" type="button" class="btn btn-primary btn-block">Editar</a>
                                <?php } elseif(isset($disable) && isset($contato)) { ?>
                                <a href="{{url ('contato/editar/'.$cliente->id) }}" type="button" class="btn btn-primary btn-block">Editar</a>
                                <?php }else{ ?>
                                <button style='margin-top:40px' type="submit" class="btn btn-primary btn-block">Gravar</button>
                                <?php } ?>
                               <i style='color:red;float:right;margin-right:15px;margin-top:10px'>*<strong style='color:#323232'> Campos Obrigatorios</strong></i>
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
                    <p>O cliente foi gravado com sucesso e já pode ser utilizado!</p>
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
                    <p>O cliente não pôde ser gravado, tente novamente mais tarde!</p>
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
                    <p>O cliente não pôde ser gravado, possivelmente já existe!</p>
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>
    </div>
    <a href="javascript:history.back()" type="button" class="btn btn-primary"><< Voltar</a>
@endsection

@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/tabel.js') !!}

@endsection