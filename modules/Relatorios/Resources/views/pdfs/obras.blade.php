@extends('frontend.layouts.pdf')

@section('title', $title)

@section('content')

	<table class='pdftable'>
		<thead>
			<tr>
				<th>{{access()->user()->locatario->fantasia}}</th>
			<th>{{date('d/m/Y')}}</th>
			<th>Algo</th>
			<th>Mais</th>	
			</tr>
		</thead>
	</table>

	<table class='pdftable'>
		<thead>
			<tr>
				<th>Nome</th>
				<th>Cliente</th>
				<th>Descrição</th>
			</tr>
		</thead>
		<tbody>
			@foreach($obras as $obra)
				<tr>
					<td>{{$obra->nome}}</td>
					<td>{{$obra->cliente->razao}}</td>
					<td>{{$obra->descricao}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@endsection