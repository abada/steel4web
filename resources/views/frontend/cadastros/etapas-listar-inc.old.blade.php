<div class="row">
    <div class="col-lg-12">

            <?php if (!empty($etapas)) { ?>
            <div class="row">
            <?php  $cont = 1;
            foreach ($etapas as $etapa) { ?>
            <div class="col-lg-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span class="text-left">
                            <a href="#" title="Editar">Código: <?=$etapa->codigo;?></a>
                        </span>
                        <span class="pull-right">
                            <a href="../etapa/editar/{{$etapa->id}}" title='Editar Etapa'> <i class="fa fa-edit fa-fw"></i></a>&nbsp;&nbsp;
                             <a title='Excluir Etapa' href="#
                            " onclick="return confirma_exclusao('<?='Código ' . $etapa->codigo;?>')" ><i class="fa fa-times"></i></a>&nbsp;&nbsp;
                        </span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <strong>Peso: </strong><?=$etapa->peso;?><br /><br />
                       
                        <hr />
                        <?php
                         if(!empty($etapa->subetapas) && $etapa->subetapas != ''){ ?>
                        <h4>Subetapas Cadastradas:</h4>
                        <?php foreach ($etapa->subetapas as $subetapa) { ?>
                        <p><a href="#">Código: <?=$subetapa->cod;?></a></p>
                        <?php } ?>
                        <?php } ?>
                        <p align="right"><a class="btn btn-primary" href="#">Cadastrar Sub-etapa</a></p>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <?php
                if($cont%3==0) {
                    echo '<div class="col-lg-12">&nbsp;</div>';
                }
                $cont++;
            ?>
            <?php } //Final do FOREACH ?>
        </div>
            <?php } else { ?>
            <div class="panel-heading">
                <h4>Nenhuma etapa cadastrada!</h4>
            </div>
            <?php } ?>

        <div class="col-lg-12 col-md-12 text-right">
           <a href="../etapa/cadastro/{{$obra->id}}" type="button" class="btn btn-primary">Cadastrar etapa</a>
        </div>
        <!-- /.panel -->
    </div>
</div>
<script>
    function confirma_exclusao(codigo) {
        if (!confirm("Deseja realmente excluir a etapa: '" + codigo + "' ?")) {
            return false;
        }
        return true;
    }
</script>