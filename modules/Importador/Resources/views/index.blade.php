@extends('frontend.layouts.master')

@section('content')
{!! Breadcrumbs::render('Importador::index') !!}
	<div class="panel panel-padrao">
		<div class="panel-heading">
			IMPORTADOR
		</div>
		<div class="navbar navbar-static-top navForm" role='navigation'>
			<form accept-charset="UTF-8" class="form-inline" role="form" id="inputImporter">
        <div class="navbar-form navbar-left">
            <div class="form-group inputObr <?php if(!isset($history)) echo 'hidden' ?>" >
                <label class="labelLine" for="">Obra: </label>
                <select id="inputChooseObra" class="form-control" required="required" name="obra">
                    <option class='optPadrao' val='abc'>Escolha Uma Obra...</option>
                    <?php foreach ($obras as $obra) { ; ?>
                    <option value="<?= $obra->id ?>" <?php if(isset($history)){if($obra->id == $etapas[0]->obra_id) echo 'selected';} ?>><?= $obra->nome ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group inputetapa <?php if(!isset($history)) echo 'hidden' ?>">
                <label class="labelLine" for=""> Etapa: </label>
                <select id="inputEtapa" class="form-control" required="required" name="etapa">
                    @if (isset($history))
                        <option value="0">Escolha uma Etapa...</option>
                    @foreach($etapas as $etapa)
                        <option value="{{$etapa->id}}" <?php if($etapa->id == $etapaID) echo 'selected'; ?>>{{$etapa->codigo}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group inputsubetapa <?php if(!isset($history)) echo 'hidden' ?>">
                <label class="labelLine" for=""> Subetapa: </label>
                <select id="inputsubetapa" class="form-control" required="required" name="inputsubetapa">
                    @if (isset($history))
                        <option value="0">Escolha uma Subetapa...</option>
                    @foreach($subetapas as $subetapa)
                        <option value="{{$subetapa->id}}" <?php if($subetapa->id == $subID) echo 'selected'; ?>>{{$subetapa->cod}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <button type="button" id='inputSubmit' class="btn btn-primary <?php if(!isset($history)) echo 'hidden' ?>" data-toggle="modal" data-target="#impScreen">Nova Importação</button>

            <div class="form-group">
             <div class="TypeLoading" style='margin-left:5px'></div>
            </div>
        </div>
    </form>

		</div>
		    <hr class='lessMargin'>
		<div class="panel-body">
			 <table class="table table-striped table-bordered  dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="noSort">
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
                    @if (isset($history))
                    @foreach($imps as $imp)
                    <tr class='tableEtapa'>
                        <td class='text-center' >
                            <i id='{{$imp->id}}' title='Importacao {{$imp->importacaoNr}}' class='clickTable fa fa-plus fa-fw'></i>
                        </td>
                        <td>{{$imp->descricao}}</td>
                        <td>{{$imp->importacaoNr}}</td>
                        <td>{{$imp->observacoes}}</td>
                        <td>
                            <div class='text-center hoverActions'>
                                    <a style='color:#f5f5f5' id='delete&{{$imp->id}}' class='delImp' title='Excluir Importacao' href='' ><i class='fa fa-times'></i>
                                </a>
                            </div>
                        </td>
                        </tr>
                        @if($imp->dbf2d != null)
                           <tr class='toBeHidden {{$imp->id}}'>
                                <td class='img-icon text-center'>
                                    <img src="{{asset('img/dbf.png')}}">
                                </td>
                                <td ><p>{{$imp->dbf2d}}</p></td>
                                <td></td>
                                <td></td>
                                <td class='text-center'>
                                    <a class='btn btn-download btn-block' title='Download' target='_blank' href="{{url('importador/download')."/".$imp->locatario_id."&".$imp->obra->cliente_id."&".$imp->obra_id."&".$imp->etapa_id."&".$imp->subetapa_id."&".$imp->importacaoNr."&".$imp->dbf2d}}"><i class='fa fa-download'></i></a>
                                </td>
                            </tr>
                        @endif
                         @if($imp->ifc_orig != null)
                           <tr class='toBeHidden {{$imp->id}}'>
                                <td class='img-icon text-center'>
                                    <img src="{{asset('img/ifc.png')}}">
                                </td>
                                <td><p>{{$imp->ifc_orig}}</p></td>
                                <td></td>
                                <td></td>
                                <td class='text-center'>
                                    <a class='btn btn-download btn-block' title='Download' target='_blank' href="{{url('importador/download')."/".$imp->locatario_id."&".$imp->obra->cliente_id."&".$imp->obra_id."&".$imp->etapa_id."&".$imp->subetapa_id."&".$imp->importacaoNr."&".$imp->ifc_orig}}"><i class='fa fa-download'></i></a>
                                </td>
                            </tr>
                        @endif
                         @if($imp->fbx_orig != null)
                           <tr class='toBeHidden {{$imp->id}}'>
                                <td class='img-icon text-center'>
                                    <img src="{{asset('img/fbx.png')}}">
                                </td>
                                <td><p>{{$imp->fbx_orig}}</p></td>
                                <td></td>
                                <td></td>
                                <td class='text-center'>
                                    <a class='btn btn-download btn-block' title='Download' target='_blank' href="{{url('importador/download')."/".$imp->locatario_id."&".$imp->obra->cliente_id."&".$imp->obra_id."&".$imp->etapa_id."&".$imp->subetapa_id."&".$imp->importacaoNr."&".$imp->fbx_orig}}"><i class='fa fa-download'></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @endif
	            </tbody>
			 </table>
				<div style='float:right;margin:15px'>
                <i style='color:#42596D;display:block' class="fa fa-square">  <span style='color:#333333'> Importação</span></i>
                    <i style='color:#333333' class="fa fa-square-o">  Arquivo</i>
                </div>
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
                        <div class="loadingImp">
                            {{ Html::image('img/200.gif', 'Importando...', array('class' => 'loadImg')) }}
                            <h3 class="saving text-center">Importando<span>.</span><span>.</span><span>.</span></h3>
                        </div>
                        <div class="tab-pane fade in active" id="tecnometal">
                            <br />
                            <h4>Importação de arquivos padrão Tecnometal</h4>
                            <br />
                            @if (Session::get('imp_danger'))
							<div class="alert alert-danger">
                                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						        @if(is_array(json_decode(Session::get('imp_danger'), true)))
						            {!! implode('', Session::get('imp_danger')->all(':message<br/>')) !!}
						        @else
						            {!! Session::get('imp_danger') !!}
						        @endif
						    </div>
						    @endif
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" method="post" action="{{ url('importador/gravar') }}" enctype="multipart/form-data" id='dbftogo'>
                                    	<div class="form-group">
                                            <label>Nome</label>
                                            <input type='text' name="descricao" class="form-control" >
                                        </div>
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
                                        <?php 
                                        $hhid = '';
                                        if(isset($history)){
                                            $impNr = count($dados->importacoes);
                                            if($impNr > 0) $hhid = 'hidden';
                                        }
                                            
                                         ?>
                                        <div class="form-group formSentido {{$hhid}}">
                                            <label>Sentido</label> <br>
                                            <input type="radio" name='sentido' value='1' id='sentido1' checked> X / Y &nbsp; &nbsp;
                                            <input type="radio" name='sentido' value='2' id='sentido2'> -X / Y &nbsp; &nbsp;
                                            <input type="radio" name='sentido' value='3' id='sentido3'> -X- / Y &nbsp; &nbsp;
                                            <input type="radio" name='sentido' value='4' id='sentido4'> X / -Y &nbsp; &nbsp;
                                        </div>

										<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <?php
                                        if(Session::get('subID')){
                                            $subID = Session::get('subID');
                                        }else{
                                            $subID = null;
                                        }
                                        ?>
                                        <input type="hidden" name="subetapa_id" id='toReceiveSubId' value="{{$subID}}">
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
    $('.loadingImp').hide();
    $('#impScreen').modal('show');
});
</script>
@endif

@endsection