@extends('backend.layouts.master')
@section('page-header')
    <h1>
       Obras
    </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading bg-padrao">
                    Listagem de obras
                </div>
                @if(!empty($obras))
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered  dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="dataTables">
                            <thead>
                                <tr>
                                    <th width="10%">Código</th>
                                    <th>Nome</th>
                                    <th>Cliente</th>
                                    <th width="10%">Data</th>
                                    <th>Status</th>
                                    <th width="10%">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($obras as $obra) {
	?>
                            <?php
if ($obra->status == 0) {
		$status = 'Inativo';
		$tipoStatus = 'danger';
		$acaoStatus = 'ativar';
	} else {
		$status = 'Ativo';
		$tipoStatus = 'success';
		$acaoStatus = 'inativar';
	}
	?>
                                <tr class="<?=$tipoStatus;?>" >
                                    <td><?=$obra->codigoObra;?></td>
                                    <td><a href="obra/{{$obra->id}}"><?=$obra->nomeObra;?></a></td>
                                    <td><?=$obra->fantasia;?></td>
                                    <td class="text-center"><?php echo date("d/m/Y", strtotime($obra->created_at)); ?></td>
                                    <td class="text-center">
                                        <span class="text-<?=$tipoStatus;?>">
                                            <?=$status;?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                             <a href="#" alt="Mudar Status" title="Mudar Status" style="text-decoration:none">
                                                <i class="fa fa-refresh fa-fw"></i>
                                            </a>
                                            <a href="../obra/editar/{{$obra->id}}" alt="Editar obra" title="Editar obra">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php }
?>
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
        <div class="col-lg-6 col-md-6">
            <a href="javascript:history.back()" type="button" class="btn btn-primary"><< Voltar</a>
        </div>
        <div class="col-lg-6 col-md-6 text-right">
           <a href="../obra/cadastro" type="button" class="btn btn-primary">Cadastrar Obra</a>
        </div>
    </div>
@endsection