@extends('frontend.layouts.master')
@section('styles')
{{ Html::style('modules/'.Module::find('Relatorios')->getLowerName().'/css/relatorios.css') }}
@endsection
@section('content')
{!! Breadcrumbs::render('Relatorios::obras') !!}
	<div class="box">

		<div class="box-header bg-padrao with-border">
			RELATORIOS DE OBRAS
		</div>

		<div class="box-body">
			<div class="navbar navbar-static-top navForm" role='navigation'>
				<form accept-charset="UTF-8" class="form-inline" role="form" id="RelObras">
		       		<div class="navbar-form navbar-left">
		           		<div class="navbar-form navbar-left">
	            			<div class="form-group relObraDiv" >
	                			<label for="obra">Obra: </label>
	                			<select id="inputRelObra" class="form-control" required="required" name="obra">
	                    			<option class='optPadrao' value='0'>Escolha uma Obra...</option>
	                     			@foreach ($obras as $obra)
	                    			<option value="<?= $obra->id ?>">{{ $obra->nome }}</option>
	                   				@endforeach
	                			</select>
	            			</div>
	            			<?php 
				            	$btnText = isset($history) ? 'Recarregar' : 'Carregar';
				             ?>
				            <button type="button" id='inputSubmit' class="btn btn-primary <?php if(!isset($history)) echo 'hidden' ?>">{{$btnText}}</button>
	            			<div class="form-group">
				             	<div class="TypeLoading hidden" style='margin-left:5px'></div>
				            </div>
						</div>
					</div>
				</form>
	 		</div>
	 		<hr>

		<table class="table table-bordered table-striped dt-responsive nowrap table-hover" id="relObraTable" cellspacing="0" width="100%">
			<thead width='100%'>
					<tr>
						<th>Nome</th>
						<th>Cliente</th>
						<th>Descricao</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
		</table>

	</div>

@endsection

@section('scripts')

{!! Html::script('modules/'.Module::find('Relatorios')->getLowerName().'/js/relatorios.js') !!}

@endsection
