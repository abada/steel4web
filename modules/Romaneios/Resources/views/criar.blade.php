@extends('frontend.layouts.master')

@section('styles')
	{{Html::style('css/romaneios.css')}}
	{{Html::style('css/datatables/select.dataTables.min.css')}}
	{{Html::style('css/datatables/dataTables.bootstrap.min.css')}}
	{{ Html::style('modules/'.Module::find('GestorDeLotes')->getLowerName().'/css/datatables.css') }}
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
	            <li><a href="#conjuntos" data-toggle="tab">Conjuntos</a>
	            </li>
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
			                <select id="inputChooseObra2" class="form-control" required="required" name="RObra">
			                    <option class='optPadrao' value='0'>Escolha Uma Obra...</option>
			                    @foreach ($obras as $obra)
			                    <option value="<?= $obra->id ?>" <?php if(isset($history)){if($obra->id == $obraID) echo 'selected';} ?>>{{ $obra->nome }}</option>
			                    @endforeach
			                </select>
			            </div>
			            <div class="form-group inputetapa2">
			                <label  for="etapa"> Etapa: </label>
			                <select id="inputEtapa2" class="form-control" required="required" name="REtapa">
			                    <option class='optPadrao' value='0'>Escolha Uma Obra...</option>
			                </select>
			            </div>
			            <div class="form-group inputsubetapa2">
			                <label for="subetapa"> Subetapa: </label>
			                <select id="inputSubetapa2" class="form-control" required="required" name="RSubetapa">
								<option class='optPadrao' value='0'>Escolha Uma Obra...</option>
			                </select>
			            </div>
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
							<input class="form-control" type="text" name='RCodigo' id='RCodigo'>
						</div>
						<div class="form-group" id='nfInputs'>
							<label for="">NFs</label>
							<input name='Rnf[]' class="form-control nfInput" type="text">
						</div>
						<div class="form-group">
							<label for="">Data de Saida</label>
							<input class="form-control" type="date" name='RSaida' id='RSaida'>
						</div>
						<div class="form-group">
							<label for="">Previsão de Chegada</label>
							<input class="form-control" type="date" name='RPrevisao' id='RPrevisao'>
						</div>
						<div class="form-group">
							<label for="">Status</label>
							<select class="form-control" name="RStatus" id="RStatus">
								@foreach(config('Romaneios.status') as $stats)
									<option value="{{$stats}}">{{$stats}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="">Observações</label>
							<textarea name="RObs" class='form-control' rows='5'></textarea>
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
									<input class="form-control" type="text" name='TNome' id='TNome'>
								</div>
								<div class="form-group">
									<label for="">Fone 1</label>
									<input class="form-control telefone" type="text" name='TFone1'>
								</div>
								<div class="form-group">
									<label for="">Fone 2</label>
									<input class="form-control telefone" type="text" name='TFone2'>
								</div>
								<div class="form-group">
									<label for="">Contato 1</label>
									<input class="form-control" type="text" name='TContato1'>
								</div>
								<div class="form-group">
									<label for="">Contato 2</label>
									<input class="form-control" type="text" name='TContato2'>
								</div>
								<div class="form-group">
									<label for="">E-Mail</label>
									<input class="form-control email_mask" type="text" name='TEmail'>
								</div>
								<div class="form-group">
									<label for="">Observações</label>
									<textarea name="TObs" class='form-control' rows='5'></textarea>
								</div>
								
							</div>
							<div class="col-md-6">
								<h4><i class="fa fa-user"></i>&nbsp;&nbsp;Motorista</h4>	
								<hr>
								<div class="form-group">
									<label for="codigo">Nome</label>
									<input class="form-control" type="text" name='MNome' id='MNome'>
								</div>
								<div class="form-group">
									<label for="">Fone 1</label>
									<input class="form-control telefone" type="text" name='MFone1'>
								</div>
								<div class="form-group">
									<label for="">Fone 2</label>
									<input class="form-control telefone" type="text" name='MFone2'>
								</div>
								<div class="form-group">
									<label for="">Caminhão</label>
									<select class="form-control" name="MCaminhao" id="">
										@foreach(config('Romaneios.caminhao') as $caminhao)
									<option value="{{$caminhao}}">{{$caminhao}}</option>
								@endforeach
									</select>
								</div>
								<div class="form-group">
									<label for="">Comprimento (M)</label>
									<input class="form-control" type="text" name='MComprimento'>
								</div>
								<div class="form-group">
									<label for="">Observações</label>
									<textarea name="MObs" class='form-control' rows='5'></textarea>
								</div>
								
							</div>
						</div>
						
				</div>
			</div>

		</div>


		<!-- ================================================================================== -->
		<!-- ================================ FINAL DOS DADOS  ================================ -->
				</div>
			</form>
        	</div>
        </div>
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
                    <option class='optPadrao' value='0'>Escolha Uma Obra...</option>
                     @foreach ($obras as $obra)
                    <option value="<?= $obra->id ?>">{{ $obra->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group inputetapa3 hidden">
                <label  for="etapa"> Etapa: </label>
                <select id="inputEtapa3" class="form-control" required="required" name="etapa">
                    <option value="0">Escolha Uma Etapa...</option>
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
</div>
	<div class="clearfix"></div>
	<hr class='lessMargin'>
	<div class="box-body">
		<table class="table table-bordered table-striped dt-responsive nowrap table-hover" id="criarRomaneioTable" cellspacing="0" width="100%">
			<thead width='100%'>
					<tr>
						<th></th>
						<th></th>
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
			<div class="box-footer">
				<button id="CriarRomaneio" class='btn btn-primary pull-right' style='margin:15px'>Enviar</button>
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
			<table class="table table-bordered table-striped hidden" style="margin:15px 5%;width:90%">
				<thead>
					<tr>
						<th>Conjunto</th>
						<th>Lote</th>
						<th>Quantidade <button class="btn btn-xs btn-primary pull-right" style="margin-right:10px"><i class="fa fa-minus-circle"></i></button></th>
					</tr>
				</thead>
				<tbody id='modalTableBody'>
					<tr>
						<td>M1</td>
						<td>Lote</td>
						<td>2</td>
					</tr>
				</tbody>
			</table>
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
{!! Html::script('js/Ajax/romaneios.js') !!}
@endsection