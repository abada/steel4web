@extends('frontend.layouts.master')

@section('content')
	<div class="panel panel-padrao">
		<div class="panel-heading">
			IMPORTADOR
		</div>
		<div class="navbar navbar-static-top navForm" role='navigation'>
			<form accept-charset="UTF-8" class="form-inline" role="form" id="inputImporter">
        <div class="navbar-form navbar-left">
            <div class="form-group">
                <label class="labelLine" for="">Obra: </label>
                <select id="inputChooseObra" class="form-control" required="required" name="obra">
                    <option class='optPadrao' val='abc'>Escolha Uma Obra...</option>
                    <?php foreach ($obras as $obra) { ; ?>
                    <option value="<?= $obra->id ?>"><?= $obra->nome ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group inputetapa hidden">
                <label class="labelLine" for=""> Etapa: </label>
                <select id="inputEtapa" class="form-control" required="required" name="etapa">
                </select>
            </div>
            <div class="form-group inputsubetapa hidden">
                <label class="labelLine" for=""> Subetapa: </label>
                <select id="inputsubetapa" class="form-control" required="required" name="inputsubetapa">
                </select>
            </div>
            <a id='inputSubmit' class="btn btn-primary hidden">Nova Importação</a>
            <div class="form-group">
             <div class="TypeLoading hidden"></div>
            </div>
        </div>
    </form>

		</div>
		    <hr class='lessMargin'>
		<div class="panel-body">
			 <table class="table table-striped table-bordered  dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="importTable">
			 	<thead>
	                <tr>
	                    <th class="text-center" width="5%"><i id='subToggle' title='Agrupar' class="fa fa-bars fa-fw"></i></th>
	                    <th width="30%">Nome</th>
	                    <th width="10%">N°</th>
	                    <th width="40%">Observacao</th>
	                    <th width="15%">Ações</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<tr class='tableEtapa'>
	            		<td></td>
	            		<td>P000</td>
	            		<td>5</td>
	            		<td>Cmpleta</td>
	            		<td>X  X</td>
	            	</tr>
	            </tbody>
			 </table>
				
			</div>
		</div>
	</div>
	 

@endsection


@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/tabel.js') !!}

@endsection