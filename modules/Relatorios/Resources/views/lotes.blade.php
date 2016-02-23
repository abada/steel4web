@extends('frontend.layouts.master')
@section('styles')
{{ Html::style('modules/'.Module::find('Relatorios')->getLowerName().'/css/relatorios.css') }}
@endsection
@section('content')
{!! Breadcrumbs::render('Relatorios::obras') !!}
	<div class="box">

		<div class="box-header bg-padrao with-border">
			RELATORIOS DE LOTES
		</div>
		<div class="box-body">
			<div class="navbar navbar-static-top navForm" role='navigation'>
				<form accept-charset="UTF-8" class="form-inline" role="form" id="RelObras">
		       		<div class="navbar-form navbar-left">
		           		<div class="navbar-form navbar-left">
	            			<div class="form-group formObra" >
	                			<label for="obra">Obra: </label>
	                			<select id="obra" class="form-control" required="required" name="obra">
	                    			<option class='optPadrao' value='0'>Escolha uma Obra...</option>
	                     			@foreach ($obras as $obra)
	                    			<option value="<?= $obra->id ?>">{{ $obra->nome }}</option>
	                   				@endforeach
	                			</select>
	            			</div>
	            			<div class="form-group formEtapa hidden" >
	                			<label for="etapa">Etapa: </label>
	                			<select id="etapa" class="form-control" required="required" name="etapa">
	                    			<option class='optPadrao' value='0'>Escolha uma Etapa...</option>
	                			</select>
	            			</div>
	            			<div class="form-group formSub hidden" >
	                			<label for="subetapa">Subetapa: </label>
	                			<select id="sub" class="form-control" required="required" name="subetapa">
	                    			<option class='optPadrao' value='0'>Escolha uma Subetapa...</option>
	                			</select>
	            			</div>
	            			<div class="form-group formLote hidden" >
	                			<label for="lote">Lote: </label>
	                			<select id="lote" class="form-control" required="required" name="lote">
	                    			<option class='optPadrao' value='0'>Escolha um Lote...</option>
	                			</select>
	            			</div>

				            <button type="button" id='inputSubmit' class="btn btn-primary hidden">Carregar</button>
	            			<div class="form-group">
				             	<div class="TypeLoading" id='TypeLoading' style='margin-left:5px'></div>
				            </div>
						</div>
					</div>
				</form>
	 		</div>

	 		<div class="row">
	 			<div class="col-md-6">
	 				<div class="box box-primary">
	 					<h4 class='box-header' style='padding-bottom:0 !important'>Conjuntos<span class='pull-right' id='pesoTot'></span></h4>
	 					<hr>
	 					<table class="table table-bordered table-striped dt-responsive nowrap table-hover" id="relTable" cellspacing="0" width="100%">
							<thead width='100%'>
									<tr>
										<th>Marca</th>
										<th>Quantidade</th>
										<th>Peso Unid. (Kg)</th>
										<th>Peso Total (Kg)</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
						</table>
	 				</div>
	 			</div>
	 			<div class="col-md-6">
	 				<div class="box box-primary">
	 					<h4 class='box-header' style='padding-bottom:0 !important'>Estagios<span class='pull-right'>Data:  {!! date('d/m/Y'); !!}</span></h4>
	 					<hr>
	 					<table class="table table-bordered table-striped dt-responsive nowrap table-hover" id="relInfoTable" cellspacing="0" width="100%">
							<thead width='100%'>
									<tr>
										<th>Estagio</th>
										<th>Data Prevista</th>
										<th>Peso(Kg)</th>
										<th>%</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
						</table>
	 				</div>
	 			</div>
	 		</div>

		

		

		<a class="btn btn-primary hidden pull-right" href='#' target='_blank' id='gerarPdf' >Gerar PDF</a>

	</div>

@endsection

@section('scripts')

{!! Html::script('modules/relatorios/js/lotes.js') !!}

@endsection
