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
                <div class="panel-heading">
                    <?=$title;?> de obra
                </div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-lg-6">
                            <form role="form" name="<?=$name;?>" id="<?=$name;?>" accept-charset="utf-8">
                                <div class="form-group">
                                    <label>Código da Obra:</label>
                                    <input class="form-control" name="codigo" id="codigo" <?php if (isset($edicao)) echo 'value="' . $obra->codigo . '"' ?>>
                                </div>
                                <div class="form-group">
                                    <label>Nome da Obra:</label>
                                    <input class="form-control" name="nome" id="nome" <?php if (isset($edicao)) echo 'value="' . $obra->nome . '"' ?>>
                                </div>
                                <div class="form-group">
                                    <label>Descrição:</label>
                                    <input class="form-control" name="descricao" id="descricao" <?php if (isset($edicao)) echo 'value="' . $obra->descricao . '"' ?>>
                                </div>

                                <div class="form-group">
                                    <label for="cidade">Cidade</label>
                                     <input class="form-control" id="cidade" name="cidade" <?php if (isset($edicao)) echo 'value="' . $obra->cidade . '"' ?>>
                                </div>

                                <div class="form-group">
                                    <label>Endereço:</label>
                                    <input class="form-control" name="endereco" id="endereco" <?php if (isset($edicao)) echo 'value="' . $obra->endereco . '"' ?>>
                                </div>

                                <div class="form-group">
                                    <label>CEP:</label>
                                    <input class="form-control cep" name="cep" id="cep" <?php if (isset($edicao)) echo 'value="' . $obra->cep . '"' ?>>
                                </div>
                            </div>
                            <!-- /.col-lg-6 (nested) -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Cliente:</label>
                                    <select class="form-control" name="clienteID" id="clienteID">
                                        <option>Selecione...</option>
                                        <?php foreach ($clientes as $cliente) { ?>
                                        <option value="<?=$cliente->id;?>" <?php if(isset($edicao) && $obra->cliente_id == $cliente->cliente_id) echo 'selected'; ?>><?=$cliente->razao;?></option>;
                                        <?php } ?>
                                    </select>
                                </div>

                               

                                <div class="form-group">
                                    <label>Montagem:</label>
                                    <select class="form-control" name="montagem" id="montagem">
                                        <option>Selecione...</option>
                                        <?php foreach ($montagens as $montagem) { ?>
                                        <option value="<?=$montagem->clienteID;?>" <?php if(isset($edicao) && $obra->montagemID == $montagem->clienteID) echo 'selected'; ?>><?=$montagem->razao;?></option>;
                                        <?php } ?>
                                    </select>
                                </div>

                                <?php if (isset($edicao)) { ?>
                                <input type="hidden" name="obraID" id="obraID" value="<?=$obraID;?>">
                                <?php } ?>

                                <button type="submit" class="btn btn-primary btn-block">Gravar</button>

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
              <img style="width:10%;margin-left:45%"src="<?=base_url('assets/img/ajax-loader.gif');?>">
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
    <a href="javascript:history.back()" type="button" class="btn btn-default"><< Voltar</a>

@endsection