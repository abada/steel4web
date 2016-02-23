@extends('frontend.layouts.pdf')

@section('title', $title)

@section('header')
<h1>{{$lote->descricao}} (Estagios/Conjuntos)</h1>
@endsection

@section('content')

	<table class="pdftable">

		<thead>
			<tr>
				<th>Lote</th>				
				<th>Obra</th>
				<th>Cliente</th>
				<th>Subetapa</th>
				<th>Etapa</th>
				<th>Peso Total</th>

			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$lote->descricao}}</td>
				<td>{{$lote->obra->nome}}</td>
				<td>{{$lote->obra->cliente->razao}}</td>
				<td>{{$lote->subetapa->cod}}</td>
				<td>{{$lote->etapa->codigo}}</td>
				<td>{{$pesoTotal}} Kg</td>				
			</tr>
		</tbody>
		
	</table>
<hr>
	<table class='pdftableBody'>
		<thead>
			<tr>
				<th>Estagio</th>
				<th>Data Prevista</th>
				<th>Peso(Kg)</th>
				<th>%</th>
			</tr>
		</thead>
		<tbody>
			@foreach($estagios as $estagio)
				<tr>
					<td>{{$estagio['estagio']}}</td>
					<td>{!! date('d/m/Y', strtotime($estagio['prev'])) !!}</td>
					<td>{{$estagio['peso']}}</td>
					<td>{{$estagio['porc']}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
<hr>
	<table class='pdftableBody'>
		<thead>
			<tr>
				<th>Marcas</th>
				<th>Quantidade</th>
				<th>Peso Unidade (Kg)</th>
				<th>Peso Total (Kg)</th>
			</tr>
		</thead>
		<tbody>
			@foreach($conjuntos as $conj)
				<tr>
					<td>{{$conj['marcas']}}</td>
					<td>{{$conj['qtd']}}</td>
					<td>{{number_format($conj['peso_unid'], 2, ',','.')}}</td>
					<td>{{number_format($conj['peso_tot'], 2, ',','.')}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
<hr>

@endsection