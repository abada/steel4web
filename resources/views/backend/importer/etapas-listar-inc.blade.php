<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading bg-padrao">
                    Listagem de Etapas
                    <div style='float:right;margin-right:15px'>
                        <i style='color:green;font-size:14px' id='tipoSuccess' class="fa fa-check-circle fa-2x hidden">  Excluido com Sucesso.</i>
                        <i style='color:red;font-size:14px' id='tipoError' class="fa fa-exclamation-circle fa-2x hidden">  Erro ao Excluir, Certifique-se que o objeto não contem dependencias.</i>
                        <i style='color:red;font-size:14px' id='tipoError2' class="fa fa-exclamation-circle fa-2x hidden">  Erro ao Excluir, Exclua a Etapa para Excluir a Subetapa Principal.</i>
                        <img src="/img/del.gif" id='tipoLoading' style='width:15px' class='hidden'>
                    </div>
                </div>
                @if(isset($obra->etapas[0]))
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered  dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="noSort">
                            <thead>
                                <tr>
                                    <th class="text-center" width="3%"><i id='subToggle' title='Alternar Subetapas' class="fa fa-bars fa-fw"></i></th>
                                    <th width="5%">Código</th>
                                    <th width="10%">Peso</th>
                                    <th width="40%">Observacao</th>
                                    <th width="10%">Data/Tipo</th>
                                    <th width="15%">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($obra->etapas as $etapa) { ?>
                                <tr class='tableEtapa'>
                                    <td class="text-center" ><i id='<?=$etapa->codigo;?>' title='Subetapas de <?=$etapa->codigo;?>' class="clickTable fa fa-minus fa-fw"></i></td>
                                    <td class="text-center"><?=$etapa->codigo;?></td>
                                    <td class="text-center"><?=$etapa->peso;?> kg</td>
                                    <td><?=$etapa->observacao;?></td>
                                    <td class="text-center"><?php echo date("d/m/Y", strtotime($etapa->created_at));?></td>
                                    <td>
                                        <div class="text-center hoverActions">
                                            <a style='color:#f5f5f5' href="../subetapa/criar/{{$etapa->id}}" title='Criar Subetapa'> <i class="fa fa-plus-square"></i></a>&nbsp;&nbsp;
                                              <a style='color:#f5f5f5' href="../etapa/editar/{{$etapa->id}}" title='Editar Etapa'> <i class="fa fa-edit fa-fw"></i></a>&nbsp;&nbsp;
                             <a style='color:#f5f5f5' name='{{$etapa->id}}' class='delEtapa' title='Excluir Etapa' href="#" 
                             ><i class="fa fa-times"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @foreach($etapa->subetapas as $subetapa)
                                    <tr class='toBeHidden <?=$etapa->codigo;?>'>
                                        <td></td>
                                        <td class="text-center"><?=$subetapa->cod;?></td>
                                        <td class="text-center"><?=$subetapa->peso;?> kg</td>
                                        <td><?=$subetapa->observacao;?></td>
                                        <td class="text-center">{{$subetapa->tipo->descricao}}</td>
                                        <td>
                                            <div class="text-center">
                                                  <a href="../subetapa/editar/{{$subetapa->id}}" title='Editar Subetapa'> <i class="fa fa-edit fa-fw"></i></a>&nbsp;&nbsp;
                                                  <a title='Excluir Subetapa' href="#" name='{{$subetapa->id}}' class='delSubEtapa'  ><i class="fa fa-times"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <?php } ?>
                            </tbody>
                        </table>
                        <div style='float:right;margin:15px'>
                        <i style='color:#42596D;display:block' class="fa fa-square">  <span style='color:#333333'>Etapa</span></i>
                            <i style='color:#333333' class="fa fa-square-o">  Subetapa</i>
                        </div>
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