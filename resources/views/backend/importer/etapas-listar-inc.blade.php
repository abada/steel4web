<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading bg-padrao">
                    Listagem de Etapas
                </div>
                @if(isset($obra->etapas[0]))
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered  dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="noSort">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th width="10%">Código</th>
                                    <th width="10%">Peso</th>
                                    <th>Observacao</th>
                                    <th width="10%">Data</th>
                                    <th width="10%">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($obra->etapas as $etapa) { ?>
                                <tr class='tableEtapa'>
                                    <td ><a href="#" class='clickTable' id='<?=$etapa->codigo;?>'>HERE</a></td>
                                    <td class="text-center"><?=$etapa->codigo;?></td>
                                    <td class="text-center"><?=$etapa->peso;?> kg</td>
                                    <td><?=$etapa->observacao;?></td>
                                    <td class="text-center"><?php echo date("d/m/Y", strtotime($etapa->created_at));?></td>
                                    <td>
                                        <div class="text-center">
                                              <a href="../etapa/editar/{{$etapa->id}}" title='Editar Etapa'> <i class="fa fa-edit fa-fw"></i></a>&nbsp;&nbsp;
                             <a title='Excluir Etapa' href="#
                            " onclick="return confirma_exclusao('<?='Código ' . $etapa->codigo;?>')" ><i class="fa fa-times"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @foreach($etapa->subetapas as $subetapa)
                                    <tr class='hidden toHide <?=$etapa->codigo;?>'>
                                        <td>-></td>
                                        <td class="text-center"><?=$subetapa->cod;?></td>
                                        <td class="text-center"><?=$subetapa->peso;?> kg</td>
                                        <td><?=$subetapa->observacao;?></td>
                                        <td class="text-center">{{$subetapa->tipo->descricao}}</td>
                                        <td>
                                            <div class="text-center">
                                                  <a href="../etapa/editar/{{$subetapa->id}}" title='Editar Etapa'> <i class="fa fa-edit fa-fw"></i></a>&nbsp;&nbsp;
                                                  <a title='Excluir Etapa' href="#
                                                     " onclick="return confirma_exclusao('<?='Código ' . $subetapa->codigo;?>')" ><i class="fa fa-times"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.panel-body -->
                @else 
                <div class="panel-heading">
                    <h4>Nada ainda cadastrado!</h4>
                </div>
                @endif
            </div>
            <!-- /.panel -->


        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-12 col-md-12 text-right">
           <a href="../etapa/cadastro/{{$obra->id}}" type="button" class="btn btn-primary">Cadastrar etapa</a>
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