{{ Form::open(['url' =>url('/gestordelotes/'), 'class'=>'form-horizontal', 'role'=>"form"]) }}
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Criar Lote</h4>
	</div>
	<div class="modal-body">

		<div class="form-group">
			<label for="inputDescricao" class="col-sm-3 control-label">Nome:</label>
			<div class="col-sm-9">
				<input type="text" name="descricao" id="inputDescricao" class="form-control" value="" required="required" tabindex="1" autofocus>
			</div>
		</div>

		<hr>

		@foreach ($estagios as $estagio)
			<div class="form-group">
				<label for="inputdataprev[{{ slug($estagio->descricao) }}]" class="col-sm-3 control-label">{{ $estagio->descricao }}</label>
				<div class="col-sm-9">
					<input type="date" placeholder="Informe a data prevista" name="data_prev[{{ $estagio->id }}]" value="{{ ($estagio->ordem <= 1)? date('Y-m-d') : '' }}" id="inputdataprev[{{ slug($estagio->descricao) }}]" class="form-control {{ ($estagio->ordem <= 1)? '' : 'disabled' }}" tabindex="{{ $estagio->ordem }}" {{ ($estagio->ordem <= 1)? 'required="required"' : '' }} min="" max="">
				</div>
			</div>
		@endforeach

		<!-- HIDDEN IDs -->
		<input type="hidden" name="obra_id" value="{{ $obra_id }}">
		<input type="hidden" name="etapa_id" value="{{ $etapa_id }}">
		<input type="hidden" name="subetapa_id" value="{{ $subetapa_id }}">
		<input type="hidden" name="grouped" value="{{ $grouped }}">

		@foreach ($conjuntos as $conjunto => $qtd)
			<input type="hidden" name="conjuntos[{{$conjunto}}]" class="form-control" value="{{ $qtd }}">
		@endforeach

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left"></i> Cancelar</button>
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
	</div>
{{ Form::close() }}

<script>
	$(function() {
		$('#modal input[type="date"]').each(function(index, item) {
			$(this).change(function(event) {
				// Desativa inputs sem data
				if(  $(this).val() != '' ){
					$(this).removeClass('disabled');
				}else{
					$(this).addClass('disabled');
				}

				if(  $(this).val() != '' ){
					var nexmindate = $(this).val();
					$(this).parent().parent().nextAll('div').children('div').find('input[type="date"]').attr('min', nexmindate);
					$(this).parent().parent().prevAll('div').children('div').find('input[type="date"]').attr('max', nexmindate);
				}

			});



		});
	});
</script>
<style>
	#modal .disabled{
		background-color: #eee;
	}
</style>