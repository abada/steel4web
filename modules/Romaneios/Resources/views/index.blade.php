@extends('frontend.layouts.master')

@section('styles')
	{{Html::style('css/romaneios.css')}}
	{{Html::style('plugins/iCheck/all.css')}}
@endsection

@section('content')

    {!! Breadcrumbs::render('Romaneios::index') !!}

	
	<div class="panel panel-padrao">

		<div class="panel-heading">
			ROMANEIOS
		</div>

		<div class="navbar navbar-static-top navForm" role='navigation'>
		<form accept-charset="UTF-8" class="form-inline" role="form" id="inputImporter">
	        <div class="navbar-form navbar-left">
	           <div class="navbar-form navbar-left">
            <div class="form-group inputObr <?php if(!isset($history)) echo 'hidden' ?>" >
                <label for="obra">Obra: </label>
                <select id="inputChooseObra" class="form-control" required="required" name="obra">
                    <option class='optPadrao' value='0'>Escolha Uma Obra...</option>
                    @foreach ($obras as $obra)
                    <option value="<?= $obra->id ?>" <?php if(isset($history)){if($obra->id == $obraID) echo 'selected';} ?>>{{ $obra->nome }}</option>
                    @endforeach
                </select>
            </div>
             <div class="form-group inputetapa <?php if(!isset($history)) echo 'hidden' ?>">
                <label  for="etapa"> Etapa: </label>
                <select id="inputEtapa" class="form-control" required="required" name="etapa">
                    @if (isset($history))
                        <option value="0">Todas</option>
                    @foreach($etapas as $etape)
                        <option value="{{$etape->id}}" <?php if(!empty($etapa->codigo)){ if($etape->id == $etapa->id) echo 'selected'; }?>>{{$etape->codigo}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group inputsubetapa <?php if(!isset($history) || empty($etapa)) echo 'hidden' ?>">
                <label for="subetapa"> Subetapa: </label>
                <select id="inputSubetapa" class="form-control" required="required" name="subetapa">
					@if (isset($history) && !empty($subetapas))
                        <option value="0">Todas</option>
                    @foreach($subetapas as $subetapa)
                        <option value="{{$subetapa->id}}" <?php if(!empty($thisSubetapa->cod)){ if($subetapa->id == $thisSubetapa->id) echo 'selected'; }?>>{{$subetapa->cod}}</option>
                    @endforeach
                    @endif
                </select>
            </div>

            <?php 
            	$btnText = isset($history) ? 'Recarregar' : 'Carregar';
             ?>
            <button type="button" id='inputSubmit' class="btn btn-primary <?php if(!isset($history)) echo 'hidden' ?>">{{$btnText}}</button>
			@if(isset($history))
			<div class="form-group checkStatus checkbox" style='margin-left:10px'>
            	<label>
            		<input  type="checkbox" name="checkStatus" id='checkStatus' value="1" checked> <span>Listar Somente Romaneios Abertos</span>
            	</label>
            </div>
			@endif
	            <div class="form-group">
	             <div class="TypeLoading" style='margin-left:5px'></div>
	            </div>
	            
	        </div>
    	</form>

	</div>
	<div class="form-group pull-right">
					<a type='button' class='btn btn-primary' href="{{url('romaneios/criar')}}">Criar Romaneio</a>
				</div>


		<div class="clearfix"></div>

	<hr class='lessMargin'>

	<div class="panel-body">
	@if(isset($history))

			 <table class="table dt-responsive nowrap" cellspacing="0" width="100%" id="lotPointer">
			 	<thead>
			 		<tr>
			 			<th>Código</th>
			 			<th>Etapa</th>
	                    <th>Subetapa</th>
	                    <th>Data de Saída</th>
	                    <th>Previsão de Chegada</th>
	                    <th>NFs</th>
	                    <th>Transportadora</th>
	                    <th>Motorista</th>
	                    <th>Observações</th>
	                    <th>Status</th>
                    </tr>
			 	</thead>
			 	<tbody>
			 		@foreach($romaneios as $romaneio)
			 			<?php $bck = ($romaneio->status == 'Fechado') ? '#EFFFF4' : '#EDF9FF' ?>
			 			<?php $stat = ($romaneio->status == 'Fechado') ? 'romClosed hidden' : 'romOpened' ?>
			 			<tr class='{{$stat}}'>
			 				<td style='background-color:{{$bck}}'><a href="{{url('romaneios/perfil').'/'.$romaneio->id}}">{{$romaneio->codigo}}</a></td>
			 				<td style='background-color:{{$bck}}'>{{$romaneio->etapa->codigo}}</td>
			 				<td style='background-color:{{$bck}}'>{{$romaneio->subetapa->cod}}</td>
			 				<td style='background-color:{{$bck}}'>{{date('d/m/Y',strtotime($romaneio->data_saida))}}</td>
			 				<td style='background-color:{{$bck}}'>{{date('d/m/Y',strtotime($romaneio->previsao_chegada))}}</td>
			 				<td style='background-color:{{$bck}}'>{!! empty($romaneio->Nfs) ? '-' : $romaneio->Nfs !!}</td>
			 				<td style='background-color:{{$bck}}'>{{$romaneio->transportadora->nome}}</td>
			 				<td style='background-color:{{$bck}}'>{{$romaneio->motorista->nome}}</td>
			 				<td style='background-color:{{$bck}}'>{!! empty($romaneio->observacoes) ? '-' : $romaneio->observacoes !!}</td>
			 				<td style='background-color:{{$bck}}'>{{$romaneio->status}}</td>
			 			</tr>
			 		@endforeach
			 	</tbody>
			 </table>
	@else
		 <table class="table table-bordered table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="lotPointer">
			 	<thead>
			 		<tr>
	                    <th>Etapa</th>
			 			<th>Subetapa</th>
	                    <th>Codigo</th>
	                    <th>Data de Saída</th>
	                    <th>Previsão de Chegada</th>
	                    <th>NFs</th>
	                    <th>Transportadora</th>
	                    <th>Motorista</th>
	                    <th>Observações</th>
	                    <th>Status</th>
                    </tr>
                 </thead>
           </table>
	@endif
	<a href='{{url("/")}}' class='btn btn-primary'><< Voltar</a>

	</div>

	</div> <!-- panel-padrao -->



@endsection

@section('scripts')
{!! Html::script('plugins/jQueryUI/jquery-ui.min.js') !!}
{!! Html::script('plugins/iCheck/icheck.min.js') !!}
{!! Html::script('modules/romaneios/js/romaneios.js') !!}
<script>
	$(document).ready(function() {
    if(urlbaseGeral == null)
    	urlbaseGeral = '<?php echo env("APP_URL") ?>' ;
	} );
</script>
{!! Html::script('js/ajax/funcoes.js') !!}
@endsection

