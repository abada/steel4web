@extends('frontend.layouts.master')
@section('content')

{!! Breadcrumbs::render('GestorDeLotes::conjuntos') !!}

<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading">
		Gestor de Lotes
	</div>

	<div class="panel-body">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="{{ url('gestordelotes') }}">Conjuntos</a>
			</li>
			<li>
				<a href="{{ url('gestordelotes/pecas') }}">Peças</a>
			</li>
		</ul>
	</div>

	<nav class="navbar navbar-static-top" role="navigation">

		{{ Form::open(['url'=>url('/gestordelotes'),  'method'=>"POST", 'class'=>"form-inline", 'role'=>"form", "id" => "createLoteForm"]) }}
		<div class="navbar-form navbar-left">
			<div class="form-group">
				<label class="" for="">Obra: </label>
				{{ Form::select('obra', $obras, old('obra_id'), ['id'=>"inputObra", 'class'=>"form-control", 'required'=>"required"]) }}
			</div>

			<div class="form-group inputetapa hidden">
				<label class="" for=""> Etapa: </label>
				{{ Form::select('etapa', $etapas, old('etapa_id'), ['id'=>"inputEtapa", 'class'=>"form-control", 'required'=>"required"]) }}
				<!-- <select name="etapa" id="inputEtapa" class="form-control" required="required"></select> -->
			</div>
			<div class="form-group inputGrouped hidden">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="inputGrouped" value="true" name="grouped" checked> Agrupado
					</label>
				</div>
			</div>
			<a id="getHandles" class="btn btn-default hidden">Carregar</a>
			<div class="form-group">
				<div class="loading hidden"></div>
			</div>
		</div>
		<div class="navbar-form navbar-left loteOptions hidden">
			<div class="form-group">
				<label>Operações de Lote: </label>

				<a id="criarlote" class="btn btn-primary" data-toggle="modal" data-target="#modal">Criar Lote</a>

				<!-- Single dropdown -->
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Associar ao Lote <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" id="lotes">
						@foreach ($lotes as $lote)
						<li><a href="#">{{ $lote->descricao }}</a></li>
						@endforeach
					</ul>
				</div>

				<a id="removerlote" class="btn btn-primary">Remover do Lote</a>
				<a id="removerpeca" class="btn btn-primary">Remover Peça do Lote</a>
				<a id="enviarlote" class="btn btn-success">Enviar para Produção <i class="fa fa-arrow-circle-right"></i></a>

			</div>
		</div>
		{{ Form::close() }}
	</nav>
	<div class="panel-body">
		<table class="table table-hover stripe" id="handlesGrid" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th> </th>
					<th>Cód.</th>
					<th>Lote</th>
					<th>Conjunto</th>
					<th>Desenho</th>
					<th>Qtd.</th>
					<th>Descrição</th>
					<th>Tratamento</th>
					<th>Engenharia</th>
					<th>PCP</th>
					<th>Preparação</th>
					<th>Gabarito</th>
					<th>Solda</th>
					<th>Pintura</th>
					<th>Expedição</th>
					<th>Montagem</th>
					<th>Entrega</th>
					<th>Status</th>
					<th>#</th>
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
</div>

@stop

@section('scripts')
<script>
	$(document).ready(function($) {

		// var urlbase = '{!! env("APP_URL") !!}';
		console.log(urlbase);

		// OBRA CHANGE
		$('#inputObra').change(function(event) {

			// 	obter etapas
			$.ajax({
				url: urlbase+'/api/obras/'+$(this).val()+'/etapas',
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					$('.loading.hidden').removeClass('hidden');
					$('.inputetapa, .inputGrouped, #getHandles').addClass('hidden');
				}
			})
			.done(function( data ) {
				$('#inputEtapa').html('');
				$('.loading').addClass('hidden');
				$('.inputetapa.hidden, .inputGrouped.hidden, #getHandles.hidden').removeClass('hidden');

				$.each(data, function(index, val) {
					$('#inputEtapa').append('<option value="'+val.id+'">'+val.codigo+'</option>');
				});
			})
			.fail(function() {

			});

		});

		if( etapa_id ){
			$('.inputetapa.hidden, .inputGrouped.hidden, #getHandles.hidden').removeClass('hidden');
		}else{
			$('#inputObra').trigger('change');
		}



		// ON CLICK AT ROW
		$('#handlesGrid tbody').on( 'click', 'tr', function (e, dt, type, indexes) {
			// SHOW/HIDE options
			if( handlesGrid.rows('.selected').data().length ){
				$('#createLoteForm').find('.loteOptions.hidden').removeClass('hidden');
			}else{
				$('#createLoteForm').find('.loteOptions').addClass('hidden');
			};


			var data = handlesGrid.rows( '.selected' ).data().pluck('id');
			selected = $.makeArray(data);
			selected = data;


	        // // var id = this.id;
	        // var indx = $.inArray(data[0], selected);

	        // if ( indx === -1 ) {
	        //     selected.push( data[0] );
	        // } else {
	        //     selected.splice( indx, 1 );
	        // }

	    } );


		/* GET HANDLES */
		$('#getHandles').click(function() {
			var url = urlbase+'/api/obras/'+$('#inputObra').val()+'/etapas/'+$('#inputEtapa').val()+'/handles';

			// GET LOTES OF ETAPA
			$.ajax({
				url: urlbase+'/api/obras/'+$('#inputObra').val()+'/etapas/'+$('#inputEtapa').val()+'/lotes',
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					$('.loading.hidden').removeClass('hidden');
					$('#lotes').addClass('hidden');
				}
			})
			.done(function( data ) {
				$('#lotes').html('');
				$('.loading').addClass('hidden');
				$('#lotes.hidden').removeClass('hidden');

				$.each(data, function(index, val) {
					$('#lotes').append('<li><a href="/lotes/'+val.id+'">'+val.descricao+'</a></li>');
				});
			})
			.fail(function() {

			});

			handlesGrid.ajax.url( url ).load();
		});

		/* On form change */
		$('#createLoteForm').change(function() {
			$(this).find('.loteOptions').addClass('hidden');
			$('#getHandles').trigger('click');
		});

		/* CRIAR LOTE */
		$('#criarlote').click(function(e) {
			e.preventDefault();

			var selectedIds = handlesGrid.rows('.selected').data();
			var handles_ids = Array();

			for (var i = 0 ; i < selectedIds.length; i++) {
				handles_ids.push( selectedIds[i].id );
			};
			$('#inputHandleIds').val( handles_ids.join(",") );

			$.ajax({
				url: urlbase+'/gestordelotes/create',
				type: 'GET',
				dataType: 'html',
				data: {
					obra_id: $('#inputObra').val(),
					etapa_id: $('#inputEtapa').val(),
					// handles_ids: $('#inputHandleIds').val(),
					handles_ids: handles_ids,
					grouped: $('#inputGrouped:checked').val(),
				}
			})
			.done(function( data ) {

				$('#modal').find('.modal-content').html(data);

			})
			.fail(function() {

			})
			.always(function() {

			});


		});


		// ON ETAPA CHANGE
		$('#inputEtapa').change(function(event) {



		});

		var handlesGrid  = $('#handlesGrid').DataTable({
			ajax: {
				url: 	urlbase+'/api/obras/'+$('#inputObra').val()+'/etapas/'+$('#inputEtapa').val()+'/handles',
				data: 	function ( d ) {
					d.grouped = $('#inputGrouped:checked').val();
				}
			},
			scrollX: true,
			responsive: true,
			columns: [
			{
				data: 			null,
				defaultContent: '',
				className: 		'select-checkbox',
				orderable: 		true,
			},
			{ data: 'fkImportacao' },
			{ data: 'fklote' },
			{ data: 'MAR_PEZ' },
			{ data: 'FLG_DWG' },
			{ data: 'QTA_PEZ' },
			{ data: 'DES_PEZ' },
			{ data: 'TRA_PEZ' },
			{ data: 'dataprojeto' },
			{ data: 'dataprev_pcp' },
			{ data: 'dataprev_preparacao' },
			{ data: 'dataprev_gabarito' },
			{ data: 'dataprev_solda' },
			{ data: 'dataprev_pintura' },
			{ data: 'dataprev_expedicao' },
			{ data: 'dataprev_montagem' },
			{ data: 'dataprev_entrega' },
			{ data: 'status' },
			{ data: 'id' },
			],
			select: {
				style:    'multi',
				selector: 'tr'
			},
			rowCallback: function( row, data ) {


		            // if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
		            	if ( $.inArray( String(data.id), selected) !== -1 ) {
		            		$(row).addClass('selected');
		            	}
		            }
		        })
			.on('preXhr.dt', function ( e, settings, data ) {
				$('.loading.hidden').removeClass('hidden');
			})
			.on('xhr.dt', function ( e, settings, json, xhr ) {
				$('.loading').addClass('hidden');
			})
			.on( 'select', function ( e, dt, type, indexes ) {
				handlesGrid[ type ]( indexes ).nodes().to$().addClass( 'selected' );
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


	/*.sidebar ul li {
	    border-bottom: 1px solid #e7e7e7;
	}
	.sidebar ul li a.active {
	    background-color: #eee;
	}*/
</style>
@stop