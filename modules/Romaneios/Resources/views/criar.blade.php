@extends('frontend.layouts.master')

@section('content')
{!! Breadcrumbs::render('Romaneios::criar') !!}
	<div class="box">
		<div class="box-header bg-padrao with-border">
			CRIAR ROMANEIO
		</div>
		
		<div class="nav-tabs-custom" style='margin-top:5px'>
			<ul class="nav nav-tabs ui-sortable-handle">
	            <li class="active">
	            	<a href="#dados" data-toggle="tab">Dados</a>
	            </li>
	            <li><a href="#conjuntos" data-toggle="tab">Conjuntos</a>
	            </li>
	        </ul>
        </div>
		<form accept-charset="UTF-8" role="form" id="RomaneiosForm">
        <div class="tab-content no-padding">
        	<div class="tab-pane fade in active" id="dados">
				<div class="box-body">
		<!-- ================================ COMECO DOS DADOS ================================ -->
		<!-- ================================================================================== -->
			
		<div class="row">
			<div class="col-md-4">
				<div class="box box-primary box-solid">
					<div class="box-header ui-sortable-handle bg-primary">
						<i class="fa fa-building-o"></i> Dados da Obra
						<div class="pull-right box-tools">
							<button class="btn btn-primary btn-sm pull-right" data-widget="collapse">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body ">
						<div class="form-group inputObr" >
			                <label for="obra">Obra: </label>
			                <select id="inputChooseObra" class="form-control" required="required" name="obra">
			                    <option class='optPadrao' value='0'>Escolha Uma Obra...</option>
			                    @foreach ($obras as $obra)
			                    <option value="<?= $obra->id ?>" <?php if(isset($history)){if($obra->id == $obraID) echo 'selected';} ?>>{{ $obra->nome }}</option>
			                    @endforeach
			                </select>
			            </div>
			            <div class="form-group inputetapa">
			                <label  for="etapa"> Etapa: </label>
			                <select id="inputEtapa" class="form-control" required="required" name="etapa">
			                    <option class='optPadrao' value='0'>Escolha Uma Obra...</option>
			                </select>
			            </div>
			            <div class="form-group inputsubetapa">
			                <label for="subetapa"> Subetapa: </label>
			                <select id="inputSubetapa" class="form-control" required="required" name="subetapa">
								<option class='optPadrao' value='0'>Escolha Uma Obra...</option>
			                </select>
			            </div>
			            <div class="form-group">
			            	<div class="TypeLoading" style='margin-left:5px'></div>
			            </div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="box box-primary box-solid">
					<div class="box-header ui-sortable-handle bg-primary">
						<i class="fa fa-tasks"></i> Dados do Romaneio
						<div class="pull-right box-tools">
							<button class="btn btn-primary btn-sm pull-right" data-widget="collapse">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body ">
						<div class="form-group">
							<label for="codigo">Codigo</label>
							<input class="form-control" type="text">
						</div>
						<div class="form-group" id='nfInputs'>
							<label for="">NF1</label>
							<input name='nf[]' class="form-control nfInput" type="text">
						</div>
						<div class="form-group">
							<label for="">Data de Saida</label>
							<input class="form-control" type="text">
						</div>
						<div class="form-group">
							<label for="">Previsão de Chegada</label>
							<input class="form-control" type="text">
						</div>
						<div class="form-group">
							<label for="">Status</label>
							<select class="form-control" name="status" id="">
								<option value="Truck">Truck</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="box box-primary box-solid">
					<div class="box-header ui-sortable-handle bg-primary">
						<i class="fa fa-truck"></i> Dados da Transportadora
						<div class="pull-right box-tools">
							<button class="btn btn-primary btn-sm pull-right" data-widget="collapse">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body ">
						<div class="form-group">
							<label for="codigo">Codigo</label>
							<input class="form-control" type="text">

						<div class="form-group">
							<label for="">Data de Saida</label>
							<input class="form-control" type="text">
						</div>
						<div class="form-group">
							<label for="">Previsão de Chegada</label>
							<input class="form-control" type="text">
						</div>
						<div class="form-group">
							<label for="">Status</label>
							<select class="form-control" name="status" id="">
								<option value="Truck">Truck</option>
							</select>
						</div>
					</div>
				</div>
			</div>

		</div>


		<!-- ================================================================================== -->
		<!-- ================================ FINAL DOS DADOS  ================================ -->
				</div>
        	</div>
        	<div class="tab-pane fade" id="conjuntos">
				<div class="box-body">
		<!-- ================================ COMECO DOS CONJUNTOS ============================ -->
		<!-- ================================================================================== -->

		<!-- ================================================================================== -->
		<!-- ================================ FINAL DOS CONJUNTOS  ============================ -->
				</div>
        	</div>
        </div>

	</div>

@endsection

@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/romaneios.js') !!}
@endsection