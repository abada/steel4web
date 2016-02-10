@extends('frontend.layouts.master')
@section('styles')

	<!-- DATATABLES BOOTSTRAP CSS-->
	{{Html::style('css/datatables/dataTables.bootstrap.min.css')}}
	{{Html::style('css/datatables/select.dataTables.min.css')}}
	{{ Html::style('modules/'.Module::find('GestorDeLotes')->getLowerName().'/css/datatables.css') }}

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

			@include('gestordelotes::_partials.menu')

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

{{ Html::script('plugins/datatables/dataTables.select.min.js') }}

{{ Html::script('modules/'.Module::find('GestorDeLotes')->getLowerName().'/js/producao.script.js') }}

@stop