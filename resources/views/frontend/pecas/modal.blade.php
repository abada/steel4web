{{ Form::open(['url' => route('lotes.store'), 'class'=>'form-horizontal', 'role'=>"form"]) }}
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Criar Lote</h4>
	</div>
	<div class="modal-body">
			
		<div class="form-group">
			<label for="inputDescricao" class="col-sm-2 control-label">Nome:</label>
			<div class="col-sm-10">
				<input type="text" name="descricao" id="inputDescricao" class="form-control" value="" required="required" tabindex="1" autofocus>
			</div>
		</div>

		<div class="form-group">
			<label for="inputDataPCP" class="col-sm-2 control-label">PCP:</label>
			<div class="col-sm-4">
				<input type="date" name="dataprev_pcp" id="inputDataPCP" class="form-control" value="{{ date('Y-m-d') }}" tabindex="2" required="required">
			</div>
		
			<label for="inputDataPintura" class="col-sm-2 control-label">Pintura:</label>
			<div class="col-sm-4">
				<input type="date" name="dataprev_pintura" id="inputDataPintura" class="form-control" value="" tabindex="6">
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputDataPreparacao" class="col-sm-2 control-label">Preparacao:</label>
			<div class="col-sm-4">
				<input type="date" name="dataprev_preparacao" id="inputDataPreparacao" class="form-control" value="" tabindex="3">
			</div>
			
			<label for="inputDataExpedicao" class="col-sm-2 control-label">Expedição:</label>
			<div class="col-sm-4">
				<input type="date" name="dataprev_expedicao" id="inputDataExpedicao" class="form-control" value="" tabindex="7">
			</div>
		</div>

		<div class="form-group">
			<label for="inputDataGabarito" class="col-sm-2 control-label">Gabarito:</label>
			<div class="col-sm-4">
				<input type="date" name="dataprev_gabarito" id="inputDataGabarito" class="form-control" value="" tabindex="4">
			</div>
			
			<label for="inputDataMontagem" class="col-sm-2 control-label">Montagem:</label>
			<div class="col-sm-4">
				<input type="date" name="dataprev_montagem" id="inputDataMontagem" class="form-control" value="" tabindex="8">
			</div>
		</div>

		<div class="form-group">
			<label for="inputDataSolda" class="col-sm-2 control-label">Solda:</label>
			<div class="col-sm-4">
				<input type="date" name="dataprev_solda" id="inputDataSolda" class="form-control" value="" tabindex="5">
			</div>
			
			<label for="inputDataEntregaFinal" class="col-sm-2 control-label">Entrega Final:</label>
			<div class="col-sm-4">
				<input type="date" name="dataprev_entrega" id="inputDataEntregaFinal" class="form-control" value="null" tabindex="9">
			</div>
		</div>

		<!-- HIDDEN IDs -->		
		<input type="hidden" name="obra_id" value="{{ $obra_id }}">
		<input type="hidden" name="etapa_id" value="{{ $etapa_id }}">
		<input type="hidden" name="grouped" value="{{ $grouped }}">
		
		@foreach ($handles_ids as $handle_id)				
		<input type="hidden" name="handles_ids[]" id="inputHandleIds" class="form-control" value="{{ $handle_id }}">
		@endforeach		

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		<button type="submit" class="btn btn-primary">Salvar</button>
	</div>
{{ Form::close() }}