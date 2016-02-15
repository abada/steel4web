@extends('frontend.layouts.master')

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
            <div class="form-group inputimp <?php if(!isset($history) || empty($subetapa) || empty($importacoes)) echo 'hidden' ?>">
                <label  for="imp"> Importacoes: </label>
                <select id="inputImp" class="form-control" required="required" name="imp">
					@if (isset($history) && !empty($importacoes))
                        <option value="0">Todas</option>
                    @if(!empty($importacoes->first()->descricao))
                    <?php 
                    	$thisimportacoesId = !empty($thisImp->id) ? $thisImp->id : 0;
                     ?>
                    @foreach($importacoes as $imp)
                        <option value="{{$imp->id}}" <?php if(!empty($thisimportacoesId)){ if($imp->id == $thisimportacoesId) echo 'selected'; }?>>{{$imp->descricao}}</option>
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

			 <table class="table table-bordered table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="lotPointer">
			 	<thead>
			 		<tr>
	                    <th>Obra</th>
	                    <th>Etapa</th>
	                    <th>Subetapa</th>
	                    <th>Importação</th>
	                    <th>Romaneio</th>
	                    <th>Lote Fab.</th>
	                    <th>Conjunto</th>
	                    <th>Projeto</th>
	                    <th>Descrição</th>
	                    <th>Tratamento</th>
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
			 		
			 		<td>{{$conjunto->obra->nome}}</td>
			 		<td>{{$conjunto->etapa->codigo}}</td>
			 		<td>{{$conjunto->subetapa->cod}}</td>
			 		<td>{{$conjunto->importacao->descricao}}</td>
			 		<td>Rom</td>
			 		<td>{{$lote}}</td>
			 		<td>{{$conjunto->MAR_PEZ}}</td>
			 		<td>{{$conjunto->NUM_COM}}</td>
			 		<td>{{$conjunto->DES_PEZ}}</td>
			 		<td>{{$conjunto->TRA_PEZ}}</td>
			 		
			 		</tr>
			 		@endforeach
			 	</tbody>
			 	<tfoot>
			 		<th><input type="text" placeholder="Obra" /></th>
			 		<th><input type="text" placeholder="Etapa" /></th>
			 		<th><input type="text" placeholder="Subetapa" /></th>
			 		<th><input type="text" placeholder="Importação" /></th>
			 		<th><input type="text" placeholder="Romaneio" /></th>
			 		<th><input type="text" placeholder="Lote Fab." /></th>
			 		<th><input type="text" placeholder="Conjunto" /></th>
			 		<th><input type="text" placeholder="Projeto" /></th>
			 		<th><input type="text" placeholder="Descrição" /></th>
			 		<th><input type="text" placeholder="Tratamento" /></th>
			 	</tfoot>
			 </table>
			 

	@else
		<div class="panel-body">Romaneio</div>
	@endif
	<a type='button' class='btn btn-primary' href="{{url('romaneios/criar')}}">Criar Romaneio</a>
	</div>

	</div> <!-- panel-padrao -->



@endsection

@section('scripts')
{!! Html::script('plugins/jQueryUI/jquery-ui.min.js') !!}
{!! Html::script('js/ajax/romaneios.js') !!}
<script>
	$(document).ready(function() {
    if(urlbaseGeral == null)
    	urlbaseGeral = '<?php echo env("APP_URL") ?>' ;
	} );
</script>
{!! Html::script('js/ajax/funcoes.js') !!}
@endsection

