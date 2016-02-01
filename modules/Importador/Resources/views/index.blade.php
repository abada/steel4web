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
            <button type="button" id='inputSubmit' class="btn btn-primary hidden" data-toggle="modal" data-target="#impScreen">Nova Importação</button>

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


	<div id="impScreen" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nova Importação</h4>
      </div>
      <div class="modal-body">
        <!-- IMPORT BEGINS -->

        	<ul class="nav nav-tabs">
                        <li class="active"><a href="#tecnometal" data-toggle="tab">Tecnometal</a>
                        </li>
                        <li><a href="#tekla" data-toggle="tab">Tekla</a>
                        </li>
                        <li><a href="#cadem" data-toggle="tab">ST_CadEM</a>
                        </li>
                        <li><a href="#manual" data-toggle="tab">Manual</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tecnometal">
                            <br />
                            <h4>Importação de arquivos padrão Tecnometal</h4>
                            <br />
                            @if (Session::get('imp_danger'))
							<div class="alert alert-danger">
						        @if(is_array(json_decode(Session::get('imp_danger'), true)))
						            {!! implode('', Session::get('imp_danger')->all(':message<br/>')) !!}
						        @else
						            {!! Session::get('imp_danger') !!}
						        @endif
						    </div>
						    @endif
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" method="post" action="/importador/gravar" enctype="multipart/form-data" id='dbftogo'>
                                        <div class="form-group">
                                            <label>Arquivo DBF</label>
                                            <input type="file" name="files[]" accept=".DBF,.dbf" id='dbfile'/>
                                        </div>
                                        <div class="form-group">
                                            <label>Arquivo IFC</label>
                                            <input type="file" name="files[]" accept=".ifc" id='ifcile'/>
                                        </div>
                                        <div class="form-group">
                                            <label>Arquivo FBX</label>
                                            <input type="file" name="files[]" accept=".fbx" id='fbxile'/>
                                        </div>
                                        <div class="form-group">
                                            <label>Observações</label>
                                            <textarea name="observacoes" class="form-control" rows="3"></textarea>
                                        </div>

										<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="subetapa_id" id='toReceiveSubId' value="">
                                        <button type="submit" class="btn btn-primary btn-block" id="subImport"><i class="fa fa-cloud-upload"></i> Importar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tekla">
                            <br />
                            <h4>Importação de arquivos padrão Tekla</h4>
                            <p>&nbsp;</p>
                            <h3>Em construção</h3>
                        </div>
                        <div class="tab-pane fade" id="cadem">
                            <br />
                            <h4>Importação de arquivos padrão ST_CadEM</h4>
                            <p>&nbsp;</p>
                            <h3>Em construção</h3>
                        </div>
                        <div class="tab-pane fade" id="manual">
                            <br />
                            <h4>Importação de arquivos Manual</h4>
                            <p>&nbsp;</p>
                            <h3>Em construção</h3>
                        </div>
                    </div>
                <!-- /.panel-body -->

        <!-- IMPORT ENDS -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
	 

@endsection





@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/tabel.js') !!}

@if (Session::get('imp_danger'))
<script>
$(document).ready(function () {
    $('#impScreen').modal('show');
});
</script>
@endif

@endsection