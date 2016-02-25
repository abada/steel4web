@extends('frontend.layouts.pdf')

@section('title', $title)

@section('header')
<h1>{{$romaneio->codigo}} (Romaneio)</h1>
@endsection

@section('content')

	<table class="pdftable">
		
		<thead>
			<tr>
				<th width='20%'>Codigo</th>				
				<th width='20%'>Nfs</th>
				<th width='20%'>Data de Saída</th>
				<th width='25%'>Previsão de Chegada</th>
				<th width='15%'>Peso Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$romaneio->codigo}}</td>
				<td>{{$romaneio->Nfs}}</td>
				<td>{{date('d/m/Y',strtotime($romaneio->data_saida))}}</td>
				<td>{{date('d/m/Y',strtotime($romaneio->previsao_chegada))}}</td>
				<td>{{number_format($pesoTotal, 2, ',','.')}} Kg</td>			
			</tr>
		</tbody>
		
	</table>
<hr>
	<table class="pdftable">
		<thead>
			<tr>
				<th width='20%'>Transportadora</th>
				<th width='15%'>Fone 1</th>
				<th width='15%'>Fone 2</th>
				<th width='15%'>Contato 1</th>
				<th width='15%'>Contato 2</th>
				<th width='20%'>E-Mail</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$romaneio->transportadora->nome}}</td>
				<td>{{$romaneio->transportadora->fone1}}</td>
				<td>{{isset($romaneio->transportadora->fone2) ? $romaneio->transportadora->fone2 : '-'}}</td>
				<td>{{$romaneio->transportadora->contato1}}</td>
				<td>{{isset($romaneio->transportadora->contato2) ? $romaneio->transportadora->contato2 : '-'}}</td>
				<td>{{$romaneio->transportadora->email}}</td>
			</tr>
		</tbody>
	</table>
<hr>
	<table class="pdftable">
		<thead>
			<tr>
				<th width='20%'>Motorista</th>
				<th width='20%'>Fone 1</th>
				<th width='20%'>Fone 2</th>
				<th width='20%'>Caminhão</th>
				<th width='20%'>Comprimento</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$romaneio->motorista->nome}}</td>
				<td>{{$romaneio->motorista->fone1}}</td>
				<td>{{isset($romaneio->motorista->fone2) ? $romaneio->motorista->fone2 : '-'}}</td>
				<td>{{$romaneio->motorista->caminhao}}</td>
				<td>{{$romaneio->motorista->comprimento}} M</td>
			</tr>
		</tbody>
	</table>
<hr>
@if(!empty($romaneio->observacoes))
	<table class="pdftable">
		<thead>
			<tr>
				<th>Observações</th>
			</tr>
		</thead>
		<tbody>
			<tr><td>{{$romaneio->observacoes}}</td></tr>
		</tbody>
	</table>
<hr>
@endif	
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
			@foreach($handles as $handle)
				<tr>
					<td>{{$handle->MAR_PEZ}}</td>
					<td>{{$handle->qtd}}</td>
					<td>{{$handle->PUN_LIS}}</td>
					<td>{{number_format($handle->peso, 2, ',','.')}}</td>	
				</tr>
			@endforeach
		</tbody>
	</table>
<hr>

@endsection