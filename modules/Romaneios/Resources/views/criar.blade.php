@extends('frontend.layouts.master')
<?php
$disabled = '';
if (isset($perfil) || isset($editar)) {
	$filled = true;
}
if (isset($perfil)) {
	if ($perfil == true) {
		$disabled = ' disabled ';
	}
}
?>
@section('styles')
	{{Html::style('css/romaneios.css')}}
	{{Html::style('css/datatables/select.dataTables.min.css')}}
	{{Html::style('css/datatables/dataTables.bootstrap.min.css')}}
	{{Html::style('modules/'.Module::find('GestorDeLotes')->getLowerName().'/css/datatables.css') }}
	{{Html::style('plugins/jQueryUI/jquery-ui.theme.min.css')}}
	{{Html::style('plugins/jQueryUI/jquery-ui.min.css')}}
	{{Html::style('plugins/jQueryUI/jquery-ui.structure.min.css')}}
	{{Html::style('plugins/iCheck/all.css')}}
@endsection

@section('content')
{!! Breadcrumbs::render('Romaneios::criar') !!}
	<div class="box">
		<div class="box-header bg-padrao with-border">
			CRIAR ROMANEIO
		</div>

		<div class="nav-tabs-custom" style='margin-top:5px'>
			<ul class="nav nav-tabs ui-sortable-handle">
	            <li class="active">
	            	<a href="#dados" data-toggle="tab">Dados</a>
	            </li>
	            @if(!isset($filled) || $perfil == false)
	            <li><a href="#conjuntos" data-toggle="tab">Conjuntos</a>
	            </li>
	            @endif
	            @if(isset($filled))
		            <li><a href="#conjuntosRom" data-toggle="tab">Conjuntos do Romaneio</a>
		            </li>
	            @endif
	        </ul>
        </div>

        <div class="tab-content no-padding">
        	<div class="tab-pane fade in active" id="dados">
				<div class="box-body">
					<form accept-charset="UTF-8" role="form" id="RomaneiosForm">
		<!-- ================================ COMECO DOS DADOS ================================ -->
		<!-- ================================================================================== -->
		<div class="row dragable">
			<div class="col-md-6">
				<div class="box box-primary box-solid">
					<div class="box-header ui-sortable-handle toMove bg-primary">
						<i class="fa fa-building-o"></i> Dados da Obra
						<div class="pull-right box-tools">
							<button class="btn btn-primary btn-sm pull-right" data-widget="collapse">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body ">
						<div class="form-group inputObr2" >
			                <label for="obra">Obra: </label>
			                <select {{$disabled}} id="inputChooseObra2" class="form-control" required="required" name="RObra">
			                    <option class='optPadrao' value='0'>Escolha uma Obra...</option>
			                    @foreach ($obras as $obra)
			                    <option value="<?=$obra->id?>" <?php
								if (isset($filled)) {
									if ($obra->id == $romaneio->obra->id) {
										echo 'selected';
									}
								}
								?>>{{ $obra->nome }}</option>
			                    @endforeach
			                </select>
			            </div>
			            <div class="form-group inputetapa2">
			                <label  for="etapa"> Etapa: </label>
			                <select {{$disabled}} id="inputEtapa2" class="form-control" required="required" name="REtapa">
			                    <option class='optPadrao' value='0'>Escolha uma Obra...</option>
			                    @if(isset($filled))
			                    	@foreach($romaneio->obra->etapas as $etapa)
			                    		<option class='optPadrao' value='{{$etapa->id}}' <?php
										if ($etapa->id == $romaneio->etapa_id) {
											echo 'selected';
										}
										?>
			                    		>{{$etapa->codigo}}</option>
			                    	@endforeach
			                    @endif
			                </select>
			            </div>
			            <div class="form-group inputsubetapa2">
			                <label for="subetapa"> Subetapa: </label>
			                <select {{$disabled}} id="inputSubetapa2" class="form-control" required="required" name="RSubetapa">
								<option class='optPadrao' value='0'>Escolha uma Obra...</option>
								@if(isset($filled))
			                    	@foreach($romaneio->etapa->subetapas as $subetapa)
			                    		<option class='optPadrao' value='{{$etapa->id}}' <?php
										if ($subetapa->id == $romaneio->subetapa_id) {
											echo 'selected';
										}
										?>
			                    		>{{$subetapa->cod}}</option>
			                    	@endforeach
			                    @endif
			                </select>
			            </div>
			            @if(isset($filled))
			            <input type="hidden" id='RomaneioID' value="{{$romaneio->id}}">
			            @endif
			            <div class="form-group">
			            	<div class="TypeLoading" style='margin-left:5px'></div>
			            </div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="box box-primary box-solid">
					<div class="box-header ui-sortable-handle toMove bg-primary">
						<i class="fa fa-tasks"></i> Dados do Romaneio
						<div class="pull-right box-tools">
							<button class="btn btn-primary btn-sm pull-right" data-widget="collapse">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="codigo">Codigo</label>
							<input {{$disabled}} class="form-control" type="text" name='RCodigo' id='RCodigo' value='<?php if (isset($filled)) {
								echo $romaneio->codigo;
							}
							?>'>
						</div>
						<div class="form-group" id='nfInputs'>
							<label for="">NFs</label>
							<?php if (isset($filled)) {
								if (!empty($romaneio->Nfs)) {
									$Nfs = explode(',', $romaneio->Nfs);
									foreach ($Nfs as $Nf) {
										if (!empty($Nf)) {
											echo '<input ' . $disabled . ' name="Rnf[]" class="form-control nfInput" type="text" value="' . $Nf . '">';
										}

									}
								}
							}
							?>
							 @if((isset($editar) && $perfil == false) || empty($romaneio->Nfs))
							<input {{$disabled}} name="Rnf[]" class="form-control nfInput" type="text">
							@endif
						</div>
						<div class="form-group">
							<label for="">Data de Saida</label>
							<input {{$disabled}} class="form-control" type="date" name='RSaida' id='RSaida' value='<?php if (isset($filled)) {
								echo date($romaneio->data_saida);
							}
							?>'>
						</div>
						<div class="form-group">
							<label for="">Previsão de Chegada</label>
							<input {{$disabled}} class="form-control" type="date" name='RPrevisao' id='RPrevisao' value='<?php if (isset($filled)) {
								echo date($romaneio->previsao_chegada);
							}
							?>'>
						</div>
						<div class="form-group">
							<label for="">Status</label>
							<select {{$disabled}} class="form-control" name="RStatus" id="RStatus">
									<option value="Fechado" <?php if (isset($filled)) {
								if ($perfil == true) {
									echo 'selected';
								}
							}
							?>>Fechado</option>
							<option value="Aberto" <?php if (isset($filled)) {
								if ($editar == true) {
									echo 'selected';
								}
							}
							?>>Aberto</option>
							</select>
						</div>
						<div class="form-group">
							<label for="">Observações</label>
							<textarea {{$disabled}} name="RObs" class='form-control' rows='5'><?php if (isset($filled)) {
								echo $romaneio->observacoes;
							}
							?></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="box box-primary box-solid">
					<div class="box-header ui-sortable-handle toMove bg-primary">
						<i class="fa fa-plane"></i> Dados de Transporte
						<div class="pull-right box-tools">
							<button class="btn btn-primary btn-sm pull-right" data-widget="collapse">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body ">
						<div class="row">
							<div class="col-md-6">

								<h4><i class="fa fa-truck"></i>&nbsp;&nbsp;Transportadora</h4>
								<hr>
								<div class="form-group">
									<label for="codigo">Nome</label>
									<input {{$disabled}} class="form-control" type="text" name='TNome' id='TNome' value='<?php if (isset($filled)) {
										echo $romaneio->transportadora->nome;
									}
									?>'>
								</div>
								<div class="form-group">
									<label for="">Fone 1</label>
									<input {{$disabled}} class="form-control telefone" type="text" name='TFone1' id='TFone' value='<?php if (isset($filled)) {
										echo $romaneio->transportadora->fone1;
									}
									?>'>
								</div>
								<div class="form-group">
									<label for="">Fone 2</label>
									<input {{$disabled}} class="form-control telefone" type="text" name='TFone2' id='TFone2' value='<?php if (isset($filled)) {
										echo $romaneio->transportadora->fone2;
									}
									?>'>
								</div>
								<div class="form-group">
									<label for="">Contato 1</label>
									<input {{$disabled}} class="form-control" type="text" name='TContato1' id='TCont' value='<?php if (isset($filled)) {
										echo $romaneio->transportadora->contato1;
									}
									?>'>
								</div>
								<div class="form-group">
									<label for="">Contato 2</label>
									<input {{$disabled}} class="form-control" type="text" name='TContato2' id='TCont2' value='<?php if (isset($filled)) {
										echo $romaneio->transportadora->contato2;
									}
									?>'>
								</div>
								<div class="form-group">
									<label for="">E-Mail</label>
									<input {{$disabled}} class="form-control email_mask" type="text" name='TEmail' id='TMail' value='<?php if (isset($filled)) {
											echo $romaneio->transportadora->email;
										}
										?>'>
								</div>
								<div class="form-group">
									<label for="">Observações</label>
									<textarea {{$disabled}} name="TObs" class='form-control' rows='5' id='TObs'><?php if (isset($filled)) {
										echo $romaneio->transportadora->observacoes;
									}
									?></textarea>
								</div>
								<input type="hidden" id='TId' name='TranId' value='0'>

							</div>
							<div class="col-md-6">
								<h4><i class="fa fa-user"></i>&nbsp;&nbsp;Motorista</h4>
								<hr>
								<div class="form-group">
									<label for="codigo">Nome</label>
									<input {{$disabled}} class="form-control" type="text" name='MNome' id='MNome' value='<?php if (isset($filled)) {
										echo $romaneio->motorista->nome;
									}
									?>'>
								</div>
								<div class="form-group">
									<label for="">Fone 1</label>
									<input {{$disabled}} class="form-control telefone" type="text" name='MFone1' id='MFone' value='<?php if (isset($filled)) {
											echo $romaneio->motorista->fone1;
										}
										?>'>
								</div>
								<div class="form-group">
									<label for="">Fone 2</label>
									<input {{$disabled}} class="form-control telefone" type="text" name='MFone2' id='MFone2' value='<?php if (isset($filled)) {
											echo $romaneio->motorista->fone2;
										}
										?>'>
								</div>
								<div class="form-group">
									<label for="">Caminhão</label>
									<select {{$disabled}} class="form-control" name="MCaminhao" id="MCam">
										@foreach(config('Romaneios.caminhao') as $caminhao)
									<option value="{{$caminhao}}" <?php if (isset($filled)) {
										if ($romaneio->motorista->caminhao == $caminhao) {
											echo 'selected';
										}
									}
									?>>{{$caminhao}}</option>
								@endforeach
									</select>
								</div>
								<div class="form-group">
									<label for="">Comprimento (m)</label>
									<input {{$disabled}} class="form-control" type="text" name='MComprimento' id='MComp' value='<?php if (isset($filled)) {
										echo $romaneio->motorista->comprimento;
									}
									?>'>
								</div>
								<div class="form-group">
									<label for="">Observações</label>
									<textarea {{$disabled}} name="MObs" class='form-control' rows='5' id='MObs'><?php if (isset($filled)) {
										echo $romaneio->motorista->observacoes;
									}
									?></textarea>
								</div>
								<input type="hidden" id='MId' name='MotId' value='0'>

							</div>
						</div>

				</div>
			</div>

		</div>
		@if(isset($editar))
		@if($editar == true)
		<button type='button' id='AtualizarDados' class="btn btn-primary pull-right" style='margin:15px'>Atualizar Dados</button>
		@endif
		@endif


		<!-- ================================================================================== -->
		<!-- ================================ FINAL DOS DADOS  ================================ -->
				</div>
			</form>
        	</div>
        </div>
        @if(!isset($filled) || $perfil == false)
        	<div class="tab-pane fade" id="conjuntos">
				<div class="box-body">
		<!-- ================================ COMECO DOS CONJUNTOS ============================ -->
		<!-- ================================================================================== -->

			<div class="navbar navbar-static-top navForm" role='navigation'>
		<form accept-charset="UTF-8" class="form-inline" role="form" id="inputImporter">
	        <div class="navbar-form navbar-left">
	           <div class="navbar-form navbar-left">
            <div class="form-group inputObr3" >
                <label for="obra">Obra: </label>
                <select id="inputChooseObra3" class="form-control" required="required" name="obra">
                    <option class='optPadrao' value='0'>Escolha uma Obra...</option>
                     @foreach ($obras as $obra)
                    <option value="<?=$obra->id?>">{{ $obra->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group inputetapa3 hidden">
                <label  for="etapa"> Etapa: </label>
                <select id="inputEtapa3" class="form-control" required="required" name="etapa">
                    <option value="0">Escolha uma Etapa...</option>
                </select>
            </div>
            <div class="form-group inputsubetapa3 hidden">
                <label for="subetapa3"> Subetapa: </label>
                <select id="inputSubetapa3" class="form-control" required="required" name="subetapa">
                    <option value="0">Todas</option>
                </select>
            </div>
            <div class="form-group inputimp3 hidden">
                <label  for="imp"> Importacoes: </label>
                <select id="inputImp3" class="form-control" required="required" name="imp">
                    <option value="0">Todas</option>
                </select>
            </div>
            <div class="form-group checkSetor checkbox hidden">
            	<label>
            		<input type="checkbox" name="checkSetor" id='checkSetor' value="1" checked> <span>Conjuntos em Expedição</span>
            	</label>
            </div>
	            <div class="form-group">
	             <div class="TypeLoading" style='margin-left:5px'></div>
	            </div>
	        </div>
    	</form>

	</div>
	@if(isset($editar))
	<button class="btn btn-success pull-right hidden" id='addHandle'>Adicionar ao Romaneio &nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
	@endif
</div>
	<div class="clearfix"></div>
	<hr class='lessMargin'>
	<div class="box-body">
		<table class="table table-bordered table-striped dt-responsive nowrap table-hover" id="criarRomaneioTable" cellspacing="0" width="100%">
			<thead width='100%'>
					<tr>
						<th></th>
						<th>Qtd. Sel.</th>
						<th>Lote</th>
						<th>Estagio</th>
						<th>Conjunto</th>
						<th>Descrição</th>
						<th>Tratamento</th>
						<th>Qtd. Total</th>
						<th>Qtd. Carregado</th>
						<th>Saldo</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
		</table>


		</div>
		<!-- ================================================================================== -->
		<!-- ================================ FINAL DOS CONJUNTOS  ============================ -->
				</div>
			</div>
		@endif
		@if(isset($filled))
		<div class="tab-pane fade" id="conjuntosRom">
				<div class="box-header">
					<span style='font-size:20px'>  Conjuntos de {{$romaneio->codigo}}</span>
					@if(isset($editar))
					<button class="btn btn-danger pull-right hidden" id='removeHandle'><i class="fa fa-arrow-left"></i>&nbsp;&nbsp; Remover do Romaneio</button>
					@endif
				</div>
				<hr>
			<div class="box-body">
				<?php $tableId = ($editar == true) ? 'RomaneioCanDel' : 'RomaneioProfile';?>
				<table class="table table-bordered table-striped dt-responsive nowrap table-hover" id="{{$tableId}}" cellspacing="0" width="100%">
					<thead width='100%'>
							<tr>
								<th></th>
								<th>Quantidade</th>
								<th>Conjunto</th>
								<th>Lote</th>
								<th>Estagio</th>
								<th>Descrição</th>
								<th>Tratamento</th>
							</tr>
						</thead>
						<tbody>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tbody>
				</table>
			</div>
		</div>

		@endif


        	</div>
			<div class="box-footer">
				<a href='{{url("romaneios")}}' class='btn btn-primary' style='margin:15px'><< Voltar</a>
			@if(!isset($filled))
				<button id="CriarRomaneio" class='btn btn-primary pull-right' style='margin:15px'>Enviar</button>
			@else
				@if($perfil == true)
					<a id="RomaneioPDF" href='{{url('romaneios/pdf').'/'.$romaneio->id}}' class='btn btn-primary pull-right' style='margin:15px'>Gerar PDF</a>
				@endif
			@endif
			</div>
        </div>

	</div>

	<div class="modal fade" id="modalRomaneio">
    <div class="modal-dialog" style='width:50%'>
    	<div class="modal-content">
      		<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h3 class="modal-title">Confirmar Envio</h3>
			</div>
			<div class="alert hidden" id='AjaxMessageModal'>
			    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>
			<div id="ModalTableWrapper">
				<table class="table table-bordered table-striped hidden" style="margin:15px 5%;width:90%" id='modalTabel'>
				<thead>
					<tr>
						<th width='35%'>Conjunto</th>
						<th width='35%'>Lote</th>
						<th width='20%'>Quantidade</th>
						<th width='10%'>
							<a href='#' class="btn btn-xs bg-maroon pull-right" id='slideModalTable' style="margin-right:10px"><i class="fa fa-minus"></i></a>
						</th>
					</tr>
				</thead>
				<tbody id='modalTableBody'>

				</tbody>
			</table>
			</div>

			<div class="modal-body modalRBody" style="margin:15px 5%;width:90%">

			</div>
		</div>
    </div>
</div>

@endsection

@section('scripts')
{!! Html::script('plugins/jQueryUI/jquery-ui.js') !!}
{{ Html::script('plugins/datatables/dataTables.select.min.js') }}
{!! Html::script('plugins/iCheck/icheck.min.js') !!}
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('modules/romaneios/js/romaneios.js') !!}
@endsection