@extends('backend.layouts.master')

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


@section('page-header')
    <h1>
        {{ $tipo }} {{ $name2 }}
    </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading bg-navy">
                    {{ $tipo }} {{ $name2 }}
                </div>
                <div class="panel-body">
                    <div class="row">

                         <div class="col-lg-6">
                            <form role="form" name="<?=$name;?>" id="<?=$name;?>" accept-charset="utf-8">
                                <div class="form-group">
                                    <label>Razão Social:</label>
                                    <input class="form-control" name="razao" id="razao" <?php if (isset($edicao)) echo 'value="' . $cliente->razao . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                <div class="form-group">
                                    <label>Nome Fantasia:</label>
                                    <input class="form-control" name="fantasia" id="fantasia" <?php if (isset($edicao)) echo 'value="' . $cliente->fantasia . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input class="form-control" name="email" id="email" <?php if (isset($edicao)) echo 'value="' . $cliente->email . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                @if(!$contato)
                                 <div class="form-group">
                                    <label>Tipo de Cliente:</label>
                                    <select class="form-control" name="tipo" id="tipo" <?php if (isset($disable)) echo 'disabled'; ?>>
                                        <option value="0" <?php if (isset($edicao) && $tipo == 0) echo 'selected'; ?>>Físico</option>
                                        <option value="1" <?php if (isset($edicao) && $tipo == 1) echo 'selected'; ?>>Jurídico</option>
                                    </select>
                                </div>
                                @else
                                    <div class="form-group">
                                    <label>Tipo de Contato:</label>
                                    <select class="form-control" name="tipo_id" id="tipo_id" <?php if (isset($disable)) echo 'disabled'; ?>>
                                        @foreach($tipos as $Type)
                                        <option value="{{$Type->id}}" <?php if (isset($edicao) && $tipo == $Type->id) echo 'selected'; ?>>{{$Type->descricao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                 <div class="form-group">
                                    <label>Documento:</label>
                                    <input class="form-control documento" name="documento" id="documento"  <?php if (isset($edicao)) echo 'value="' . $cliente->documento . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                <div class="form-group">
                                    <label>Inscrição Estadual:</label>
                                    <input class="form-control" name="inscricao" id="inscricao"  <?php if (isset($edicao)) echo 'value="' . $cliente->inscricao . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                                 <div class="form-group">
                                    <label>Telefone:</label>
                                    <input class="form-control telefone" name="telefone" id="telefone" <?php if (isset($edicao)) echo 'value="' . $cliente->fone . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>
                            </div>
                            <!-- /.col-lg-6 (nested) -->
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label>Endereço:</label>
                                    <input class="form-control" name="endereco" id="endereco" <?php if (isset($edicao)) echo 'value="' . $cliente->endereco . '"' ?> <?php if (isset($disable)) echo 'disabled'; ?>>
                                </div>

                                <div class="form-group">
                                    <label>CEP:</label>
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
                                <?php if (isset($edicao) || isset($disable)){ ?>
                                <input type="hidden" name="id" id="id" value="{{$cliente->id}}">
                                <?php } ?>
                                <?php if (isset($disable)) { ?>
                                <a href="editar/{{$cliente->id}}" type="button" class="btn btn-primary btn-block">Editar</a>
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