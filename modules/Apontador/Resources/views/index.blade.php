@extends('frontend.layouts.master')

@section('content')

    {!! Breadcrumbs::render('Apontador::index') !!}
	
	<div class="panel panel-padrao">

		<div class="panel-heading">
			APONTADOR
		</div>

	<div class="navbar navbar-static-top navForm" role='navigation'>
		<form accept-charset="UTF-8" class="form-inline" role="form" id="inputImporter">
	        <div class="navbar-form navbar-left">
	           <div class="navbar-form navbar-left">
            <div class="form-group inputObr <?php if(!isset($history)) echo 'hidden' ?>" >
                <label class="labelLine" for="obra">Obra: </label>
                <select id="inputChooseObra" class="form-control" required="required" name="obra">
                    <option class='optPadrao' value='0'>Escolha Uma Obra...</option>
                    <?php foreach ($obras as $obra) { ; ?>
                    <option value="<?= $obra->id ?>" <?php if(isset($history)){if($obra->id == $etapa->obra_id) echo 'selected';} ?>><?= $obra->nome ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group inputetapa <?php if(!isset($history)) echo 'hidden' ?>">
                <label class="labelLine" for="etapa"> Etapa: </label>
                <select id="inputEtapa" class="form-control" required="required" name="etapa">
                    @if (isset($history))
                        <option value="0">Escolha uma Etapa...</option>
                    @foreach($etapas as $etape)
                        <option value="{{$etape->id}}" <?php if($etape->id == $etapa->id) echo 'selected'; ?>>{{$etape->codigo}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group inputsubetapa <?php if(!isset($history)) echo 'hidden' ?>">
                <label class="labelLine" for="subetapa"> Subetapa: </label>
                <select id="inputSubetapa" class="form-control" required="required" name="subetapa">
					@if (isset($history))
                        <option value="0">Escolha uma Subetapa...</option>
                    @foreach($subetapas as $subetapa)
                        <option value="{{$subetapa->id}}" <?php if($subetapa->id == $thisSubetapa->id) echo 'selected'; ?>>{{$subetapa->cod}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group inputlote <?php if(!isset($history)) echo 'hidden' ?>">
                <label class="labelLine" for="lote"> Lote: </label>
                <select id="inputLote" class="form-control" required="required" name="lote">
					@if (isset($history))
                        <option value="0">Todos</option>
                    @if(!empty($lotes->first()->descricao))
                    <?php 
                    	$thisLoteId = !empty($thisLote->id) ? $thisLote->id : 0;
                     ?>
                    @foreach($lotes as $lote)
                        <option value="{{$lote->id}}" <?php if($lote->id == $thisLoteId) echo 'selected'; ?>>{{$lote->descricao}}</option>
                    @endforeach
                    @endif
                    @endif
                </select>
            </div>
            <?php 
            	$btnText = isset($history) ? 'Recarregar' : 'Carregar';
             ?>
            <button type="button" id='inputSubmit' class="btn btn-primary <?php if(!isset($history)) echo 'hidden' ?>" data-toggle="modal" data-target="#impScreen">{{$btnText}}</button>

	            <div class="form-group">
	             <div class="TypeLoading" style='margin-left:5px'></div>
	            </div>
	        </div>
    	</form>
	</div>
		<div class="clearfix"></div>
	<hr class='lessMargin'>
	<div class="panel-body">
	@if(isset($history))

			 <table class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="lotPointer">
			 	<thead>
			 		<tr>
	                    <th>Lote</th>
	                    <th>Conjunto</th>
	                    <th>Projeto</th>
	                    <th>Qtd.</th>
	                    <th>Descricao</th>
	                    <th>Tratamento</th>
	                    @foreach($estagios as $estagio)
	                    <th>{{$estagio->decricao}} Qtd</th>
	                    <th>Data Real {{$estagio->descricao}}</th>
	                    @endforeach
                    </tr>
			 	</thead>
			 	<tbody>
			 		@foreach($conjuntos as $conjunto)
			 		<?php if(isset($conjunto->lote->descricao)){
				 			$lote = $conjunto->lote->descricao;
				 			$hasLotes = true;
				 		  }else{
				 		  	$lote = ' - ';
				 		  	$hasLotes = false;
				 		  }  ?>
			 		<tr>
			 			<td>{{$lote}}</td>
			 		<td>{{$conjunto->MAR_PEZ}}</td>
			 		<td>{{$conjunto->NUM_COM}}</td>
			 		<td>{{$conjunto->qtd}}</td>
			 		<td>{{$conjunto->DES_PEZ}}</td>
			 		<td>{{$conjunto->TRA_PEZ}}</td>
			 		@foreach($estagios as $estagio)
	                    <td><input type="number" class="row-qtd" name="qtd&&{{$estagio->id}}&{{$conjunto->id}}" value="" min='0' max='10' placeholder='2' style='line-height:19px'></td>
	                    <td><input type="date" class="row-date" name="date&&{{$estagio->id}}&{{$conjunto->id}}" style='line-height:15px' value=''></td>
                    @endforeach
			 		</tr>
			 		@endforeach
			 	</tbody>
			 </table>
			 <button id="pointButton">Enviar</button>

	@else
		<div class="panel-body">Aqui voce aponta os apontamentos apontadamente apontados (<i class="fa fa-hand-o-right"></i>)</div>
	@endif
	</div>
	</div> <!-- panel-padrao -->



@endsection

@section('scripts')

{!! Html::script('js/ajax/apontador.js') !!}
<script>
	$(document).ready(function() {
    if(urlbaseGeral == null)
    	urlbaseGeral = '<?php echo env("APP_URL") ?>' ;
	} );
</script>
{!! Html::script('js/ajax/funcoes.js') !!}
@endsection


