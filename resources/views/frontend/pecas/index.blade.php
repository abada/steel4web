@extends('templates.default')
@section('content')

{!! Breadcrumbs::render('pecas') !!}

<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading">
		Gestor de Lotes
	</div>

	<div class="panel-body">
	    <!-- Nav tabs -->
	    <ul class="nav nav-tabs">
	        <li>
	            <a href="{{ url('lotes') }}">Conjuntos</a>
	        </li>
	        <li class="active">
	            <a href="{{ url('lotes/pecas') }}">Peças</a>
	        </li>
	    </ul>
	</div>

	<nav class="navbar navbar-static-top navbar-inverse" role="navigation">
		{{ Form::open(['method'=>"POST", 'class'=>"form-inline", 'role'=>"form", "id" => "createLoteForm"]) }}
		<div class="navbar-form navbar-left">
			<div class="form-group">
				<label class="" for="">Obra: </label>
				<select name="obra" id="inputObra" class="form-control" required="required">
					@foreach ($obras as $obra)
					<option value="{{ $obra->id }}">{{ $obra->descricao }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group inputetapa hidden">
				<label class="" for=""> Etapa: </label>
				<select name="etapa" id="inputEtapa" class="form-control" required="required"></select>
			</div>
			<div class="form-group inputGrouped hidden">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="inputGrouped" value="true" name="grouped" checked> Agrupado
					</label>
				</div>
			</div>
			<a id="getPecas" class="btn btn-default hidden">Carregar</a>
			<div class="form-group">
				<div class="loading hidden"></div>
			</div>
		</div>

		{{ Form::close() }}
	</nav>
	<div class="panel-body">
		<table class="table table-hover stripe" id="pecasGrid" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Cód.</th>
					<th>Peça</th>
					<th>Qtd.</th>
					<th width="150">Categoria</th>
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



@stop
@section('scripts')
<script>
	$(document).ready(function($) {

		// var urlbase = '{!! env("APP_URL") !!}';

		// OBRA CHANGE -> obtem etapas
		$('#inputObra').change(function(event) {

			// 	obter etapas
			$.ajax({
				url: urlbase+'/obras/'+$(this).val()+'/etapas',
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					$('.loading.hidden').removeClass('hidden');
					$('.inputetapa, .inputGrouped, #getPecas').addClass('hidden');
				}
			})
			.done(function( data ) {
				$('#inputEtapa').html('');
				$('.loading').addClass('hidden');
				$('.inputetapa.hidden, .inputGrouped.hidden, #getPecas.hidden').removeClass('hidden');

				$.each(data, function(index, val) {
					$('#inputEtapa').append('<option value="'+val.id+'">'+val.identificacao+'</option>');
				});
			})
			.fail(function() {
				console.log("error obtain etapas");
			});

		});

		$('#inputObra').trigger('change');

		var pecasGrid  = $('#pecasGrid').DataTable({
			ajax: {
				url: 	urlbase+'/obras/'+$('#inputObra').val()+'/etapas/'+$('#inputEtapa').val()+'/pecas',
				data: 	function ( d ) {
					d.grouped = $('#inputGrouped:checked').val();
					d.flg_rec = 4;
				}
			},
			scrollX: true,
			responsive: true,
			columns: [
				{ data: 'fkImportacao' },
				{ data: 'POS_PEZ' },
				{ data: 'QTA_PEZ' },
				// { data: 'NOM_PRO' },
				// { data: 'CATEPERFIL' },
				{ data:
					function (data, type, full) {
						if (type === 'display' && data.CATEPERFIL <= 30) {
					       	return '<img src="'+urlbase+'/img/icons/'+data.CATEPERFIL+'.png" /> &nbsp; '+data.NOM_PRO;
						}
						return data.CATEPERFIL;
					}
		        },
			]
		})
		.on('preXhr.dt', function ( e, settings, data ) {
			$('.loading.hidden').removeClass('hidden');
		})
		.on('xhr.dt', function ( e, settings, json, xhr ) {
			$('.loading').addClass('hidden');
		});


	/* GET PEÇAS */
	$('#getPecas').click(function() {

		var url = urlbase+'/obras/'+$('#inputObra').val()+'/etapas/'+$('#inputEtapa').val()+'/pecas';
		pecasGrid.ajax.url( url ).load();

	});

	/* On form change */
	$('#createLoteForm').change(function() {
		$('#getPecas').trigger('click');
	});

});
</script>
<style>
	div.dataTables_wrapper {
		width: 100%;
		margin: 0 auto;
	}
	/* Loading */
	.loading {
		width: 32px;
		height: 32px;
		clear: both;
		margin: auto;
		border: 4px rgba(51,51,51,0.25) solid;
		border-top: 4px rgba(51,51,51,1) solid;
		border-radius: 50%;
		-webkit-animation: loadingAnimation .6s infinite linear;
		animation: loadingAnimation .6s infinite linear;
	}
	@-webkit-keyframes loadingAnimation {
		from { -webkit-transform: rotate(0deg); }
		to { -webkit-transform: rotate(359deg); }
	}
	@keyframes loadingAnimation {
		from { transform: rotate(0deg); }
		to { transform: rotate(359deg); }
	}
</style>
@stop