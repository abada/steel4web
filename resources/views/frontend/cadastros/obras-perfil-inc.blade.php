<div class="obraContatos">
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Detalhes da obra
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <address>
                    <strong><?=$obra->nome;?></strong><br />
                    <?php if(!empty($obra->codigo)) echo '<strong>Código: ' . $obra->codigo . '</strong><br /><br />';?>
                    <?php if(!empty($obra->endereco)) echo $obra->endereco . '<br />';?>
                    <?php if(!empty($obra->nomeCidade)) echo $obra->nomeCidade . ', ' . $obra->nomeEstado . ' - ' . $obra->uf . '<br />';?>
                    <?php if(!empty($obra->cep)) echo 'CEP: ' . $obra->cep . '<br />';?>
                    <?php if(!empty($obra->descricao)) { ?>
                    <em><?=$obra->descricao;?></em>
                    <?php } ?>
                </address>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php if (isset($cliente)) { ?>
    <div class="col-lg-4">
        <div class="panel panel-green">
            <div class="panel-heading">
                Detalhes do cliente
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <address>
                    <?php
                        if(!empty($cliente->fantasia)) echo '<strong>' . $cliente->fantasia . '</strong><br />';
                        if(!empty($cliente->razao)) echo '<strong>' . $cliente->razao . '</strong><br />';
                        echo '<br />';
                        if(!empty($cliente->email)) echo 'Email: ' . $cliente->email . '<br />';
                        if(!empty($cliente->site)) echo 'Site: ' . $cliente->site . '<br />';
                        if(!empty($cliente->endereco)) echo $cliente->endereco . '<br />';
                        if(!empty($cliente->nomeCidade)) echo $cliente->nomeCidade . ', ' . $cliente->nomeEstado . ' - ' . $cliente->uf . '<br />';
                        if(!empty($cliente->cep)) echo 'CEP: ' . $cliente->cep . '<br />';
                        if(!empty($cliente->fone)) echo 'Fone: ' . $cliente->fone;
                    ?>
                </address>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php } ?>
    @if(isset($contatos))
   @foreach($contatos as $contato)
    <div class="col-lg-4">
        <div class="panel panel-padrao">
            <div class="panel-heading">
             @if(!empty($contato->tipo->descricao))
                 {{$contato->tipo->descricao}}
             @endif
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <address>
                    <?php
                        if(!empty($contato->fantasia)) echo '<strong>' . $contato->fantasia . '</strong><br />';
                        if(!empty($contato->razao)) echo '<strong>' . $contato->razao . '</strong><br />';
                        echo '<br />';
                        if(!empty($contato->email)) echo 'Email: ' . $contato->email . '<br />';
                        if(!empty($contato->site)) echo 'Site: ' . $contato->site . '<br />';
                        if(!empty($contato->endereco)) echo $contato->endereco . '<br />';
                        if(!empty($contato->cidade)) echo $contato->cidade . '<br />';
                        if(!empty($contato->cep)) echo 'CEP: ' . $contato->cep . '<br />';
                        if(!empty($contato->fone)) echo 'Fone: ' . $contato->fone;
                        if(!empty($contato->documento)) echo 'Documento: ' . $contato->documento . '<br />';
                        if(!empty($contato->responsavel)) echo 'Responsavel: ' . $contato->responsavel . '<br />';
                        if(!empty($contato->crea)) echo 'CREA: ' . $contato->crea . '<br />';
                    ?>
                </address>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
   @endforeach
   @endif

</div>
</div>