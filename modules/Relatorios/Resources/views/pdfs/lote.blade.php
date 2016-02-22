@extends('frontend.layouts.pdf')

@section('title', $title)

@section('content')

	<table class="pdftable">

		<thead>
			<tr>
				<th>Lote</th>				
				<th>Obra</th>
				<th>Cliente</th>
				<th>Subetapa</th>
				<th>Etapa</th>
				<th>Data</th>

			</tr>
		</thead>
		<tbody>
			<tr>
				<th>{{$lote->descricao}}</th>
				<th>{{$lote->obra->nome}}</th>
				<th>{{$lote->obra->cliente->razao}}</th>
				<th>{{$lote->subetapa->cod}}</th>
				<th>{{$lote->etapa->codigo}}</th>
				<th>{!! date('d/m/Y'); !!}</th>				
			</tr>
		</tbody>
		
	</table>

	<table class='pdftable'>
		<thead>
			<tr>
				<th colspan='3' style='text-align:center'>Estagios</th>
			</tr>
		</thead>
		<thead>
			<tr>
				<th>Estagio</th>
				<th>Data de Término Prevista</th>
				<th>Conjuntos(quantidade)</th>
			</tr>
		</thead>
		<tbody>
			@foreach($cronos as $crono)
				<tr>
					<td>{{$crono->estagio->descricao}}</td>
					<td>{!! date('d/m/Y', strtotime($crono->data_prev)) !!}</td>
					<?php 
					$count = 0;
						foreach($crono->estagio->handles as $hand){
							if($hand->lote_id == $crono->lote_id) $count++;
						}
					 ?>
					<td>{{$count}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<table class='pdftable'>
		<thead>
			<tr>
				<th colspan='4' style='text-align:center'>Conjuntos</th>
			</tr>
		</thead>
		<thead>
			<tr>
				<th>Marcas</th>
				<th>Quantidade</th>
				<th>Peso Unidade</th>
				<th>Peso Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach($conjuntos as $conj)
				<tr>
					<td>{{$conj['marcas']}}</td>
					<td>{{$conj['qtd']}}</td>
					<td>{{$conj['peso_unid']}}</td>
					<td>{{$conj['peso_tot']}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@endsection