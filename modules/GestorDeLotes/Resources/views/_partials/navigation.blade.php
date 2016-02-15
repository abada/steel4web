<nav class="navbar" role="navigation">

	<div class="navbar-form navbar-left" id="">

		<div class="form-group">
			<label class="" for="inputObra">Obra: </label>
			@if( null != @$nav['obras'] )
			{{ Form::select('obra',$nav['obras']['all'], $nav['obras']['selected'], ['placeholder'=>'-- Selecione uma Obra --', 'id'=>"inputObra", 'class'=>"form-control", 'required'=>"required"] ) }}
			@else
			{{ Form::select('obra', $obras, old('obra_id', NULL), ['placeholder'=>'-- Selecione uma Obra --', 'id'=>"inputObra", 'class'=>"form-control", 'required'=>"required"] ) }}
			@endif
		</div>

		<div class="form-group inputetapa hidden">
			<label class="" for="inputEtapa"> Etapa: </label>
			@if( null != @$nav['etapas'] )
			{{ Form::select('etapa',$nav['etapas']['all'], $nav['etapas']['selected'], ['id'=>"inputEtapa", 'class'=>"form-control", 'required'=>"required"]) }}
			@else
			{{ Form::select('etapa',[""=>""], old('etapa_id'), ['id'=>"inputEtapa", 'class'=>"form-control", 'required'=>"required"]) }}
			@endif
		</div>
		<div class="form-group inputsubetapa hidden">
			<label class="" for="inputSubetapa"> Subetapa: </label>
			@if( null != @$nav['subetapas'] )
			{{ Form::select('subetapa', $nav['subetapas']['all'], $nav['subetapas']['selected'], ['id'=>"inputSubetapa", 'class'=>"form-control", 'required'=>"required"]) }}
			@else
			{{ Form::select('subetapa', [""=>""], old('subetapa_id'), ['id'=>"inputSubetapa", 'class'=>"form-control", 'required'=>"required"]) }}
			@endif
		</div>

		<a id="getHandles" class="btn btn-default hidden" href="/gethandles">Carregar</a>
		<div class="form-group">
			<div class="loading hidden"></div>
		</div>
	</div>

</nav>