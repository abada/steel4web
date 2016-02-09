@extends('frontend.layouts.master')
@section('styles')

	<!-- DATATABLES BOOTSTRAP CSS-->
	{{Html::style('css/datatables/dataTables.bootstrap.min.css')}}
	{{Html::style('css/datatables/select.dataTables.min.css')}}
	{{ Html::style('modules/'.Module::find('GestorDeLotes')->getLowerName().'/css/datatables.css') }}
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
@section('content')

{!! Breadcrumbs::render('GestorDeLotes::conjuntos') !!}

<div class="box">
	<!-- Default box contents -->
	<div class="box-header with-border bg-padrao text-uppercase">
		<h3 class="box-title">Gestor de Lotes</h3>
	</div>

	{{ Form::open(['url'=>url('/gestordelotes'),  'method'=>"POST", 'class'=>"form-inline", 'role'=>"form", "id" => "createLoteForm"]) }}
	<div class="box-body">

		<!-- Nav tabs -->
		<ul class="nav nav-tabs">

			<div class="form-group pull-right loteOptions hidden">
				<label>Operações de Lote: </label>

				<!-- Single dropdown -->
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Associar ao Lote <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" id="lotes">
						@foreach ($lotes as $lote)
						<li><a href="{{ url('gestordelotes/lotes/'.$lote->id.'/associar') }}">{{ $lote->descricao }}</a></li>
						@endforeach
					</ul>
				</div>

				<a id="removerconjuntos" class="btn btn-primary">Remover conjunto do Lote</a>
				<a id="removerlote" class="btn btn-primary">Remover Lote inteiro</a>
				<a id="enviarlotes" class="btn btn-success">Enviar para Produção <i class="fa fa-arrow-circle-right"></i></a>

			</div>

			<li>
				<a href="{{ url('gestordelotes') }}">Conjuntos</a>
			</li>
			<li class="active">
				<a>Lotes</a>
			</li>
			<li>
				<a href="{{ url('gestordelotes/pecas') }}">Peças</a>
			</li>


		</ul>
	</div>

	<nav class="navbar" role="navigation">

		<div class="navbar-form navbar-left">
			<div class="form-group">
				<label class="" for="inputObra">Obra: </label>
				{{ Form::select('obra', $obras, old('obra_id', NULL), ['id'=>"inputObra", 'class'=>"form-control", 'required'=>"required"] ) }}
			</div>

			<div class="form-group inputetapa hidden">
				<label class="" for="inputEtapa"> Etapa: </label>
				{{ Form::select('etapa',[""=>""], old('etapa_id'), ['id'=>"inputEtapa", 'class'=>"form-control", 'required'=>"required"]) }}
			</div>
			<div class="form-group inputsubetapa hidden">
				<label class="" for="inputSubetapa"> Subetapa: </label>
				{{ Form::select('subetapa', [""=>""], old('subetapa_id'), ['id'=>"inputSubetapa", 'class'=>"form-control", 'required'=>"required"]) }}
			</div>

			<!-- <div class="form-group inputGrouped hidden">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="inputGrouped" value="true" name="grouped" checked> Agrupado
					</label>
				</div>
			</div> -->
			<a id="getHandles" class="btn btn-default hidden">Carregar</a>
			<div class="form-group">
				<div class="loading hidden"></div>
			</div>
		</div>

	</nav>
	{{ Form::close() }}
	<div class="box-body">
		<table class="table table-hover stripe" id="handlesGrid" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="50"></th>
					<th></th>
					<th>Qtd.</th>
					<th>Import.</th>
					<th>Lote</th>
					<th>Conjunto</th>
					<th>Desenho</th>
					<th>Tipologia</th>
					<th>Tratamento</th>
					<th>Engenharia</th>

					@foreach ($estagios as $estagio)
						<th>{{ $estagio->descricao }}</th>
					@endforeach

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
					@foreach ($estagios as $estagio)
						<td></td>
					@endforeach
				</tr>
			</tbody>
		</table>
	</div>
</div>

@stop

@section('scripts')

<!-- DATATABLES JS -->
{{-- Html::script('plugins/datatables/jquery.datatables.min.js') --}}
<!-- DATATABLES BOOTSTRAP JS -->

{{ Html::script('plugins/datatables/dataTables.select.min.js') }}

{{ Html::script('modules/'.Module::find('GestorDeLotes')->getLowerName().'/js/lotes.script.js') }}

@stop