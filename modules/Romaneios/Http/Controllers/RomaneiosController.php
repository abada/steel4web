<?php namespace Modules\Romaneios\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Obra as obr;
use App\Etapa as etap;
use App\Subetapa as sub;
use App\Importacao as imp;
use App\Handle as handle;
use App\Estagio as est;
use App\Lote as lote;
use App\Transportadora as tran;
use App\Motorista as mot;
use App\Romaneio as rom;
use Log;
use PDF;

class RomaneiosController extends Controller {
	
	public function index()
	{
		$obras = obr::has('romaneios')->where('status',1)->get(); 
		if(\Session::get('history')){

        	$ids = (\Session::get('history'));
        	if($ids['eID'] == 0)
        		$romaneios = rom::where('obra_id',$ids['oID'])->get();
        	else{
        		$eid = $ids['eID'];
        		$romaneios = rom::where('obra_id',$ids['oID'])->whereHas('etapas', function($q) use ($eid){
				 	$q->where('etapa_id',$eid);
				 })->get();
        	}
        		

        	$obraID = $ids['oID'];
        	$etapas = etap::has('romaneios')->where('obra_id',$ids['oID'])->get();
        	if($ids['eID'] != 0){
				$etapa = etap::find($ids['eID']);
			}else{
				$etapa = null;
			}     
            $history = true;
            return view('romaneios::index',compact('obras','obraID', 'etapas', 'romaneios','history','etapas', 'etapa'));
        }
		return view('romaneios::index', compact('obras'));
	}

	public function setHistory(Request $request){
		$dados = $request->all();
		\Session::flash('history', $dados);
		return route('romaneios');
	}

	public function perfil($id){
		$romaneio = rom::find($id);
		if($romaneio == null){
			return redirect('romaneios')->withFlashDanger('Romaneio não encontrado.');
		}
		$obras = obr::has('lotes')->where('status',1)->get(); 
		
		$editar = false;
		$perfil = true;
		$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('romaneio_id',$id)->where('FLG_REC', 3)->groupBy('MAR_PEZ')->get();
		$pesoTotal = $this->getPeso($id);
		if($romaneio->status != 'Fechado'){
			$handles = 0;
			$editar = true;
			$perfil = false;
		}
		return view('romaneios::criar', compact('obras','romaneio','editar','perfil','handles','pesoTotal'));
	}

	public function getPeso($id){
		$pesoTotal = 0;
		$handles = handle::selectRaw('*')->where('romaneio_id',$id)->where('FLG_REC', 3)->get();
		 foreach($handles as $handle){
		 		$pesoTotal = $handle->PUN_LIS + $pesoTotal;
		 }
		 return number_format($pesoTotal, 2, ',','.');
	}

	public function criar(){
		$obras = obr::has('lotes')->where('status',1)->get(); 
		return view('romaneios::criar', compact('obras'));
	}

	public function getConjuntos($params){
		if($params == "0X0X0X0X0" || $params == "0X0X0X0X1"){
			$data = array(
				'' => ''
			);
		}else{
			$data = array();
			$dados = explode('X', $params);
			if(empty($dados[1])){
				// $handlesTotal = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('obra_id',$dados[0])->where('FLG_REC', 3)->has('lote')->groupBy('MAR_PEZ')->get();
				// $handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('obra_id',$dados[0])->where('FLG_REC', 3)->has('lote')->groupBy('MAR_PEZ')->groupBy('estagio_id')->get();
				// $handlesDisp = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
				// 	$q->where('tipo',3);
				// })->where('obra_id',$dados[0])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->groupBy('estagio_id')->get();
				// $handlesCar = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
				// 	$q->where('tipo',4);
				// })->where('obra_id',$dados[0])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->groupBy('estagio_id')->get();
				$response['data'] =  $data;
				return json_encode($response);
			}
			elseif(empty($dados[2])){
				$handlesTotal = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('FLG_REC', 3)->has('lote')->groupBy('MAR_PEZ')->get();
				$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('FLG_REC', 3)->has('lote')->groupBy('MAR_PEZ')->groupBy('estagio_id')->get();
				$handlesDisp = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->groupBy('estagio_id')->get();
				$handlesCar = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',12);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->groupBy('estagio_id')->get();
			}elseif(empty($dados[3])){
				$handlesTotal = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->has('lote')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->get();
				$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->has('lote')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
				$handlesDisp = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
				$handlesCar = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',12);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
			}else{
				$handlesTotal = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->has('lote')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('importacao_id',$dados[3])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->get();
				$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->has('lote')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('importacao_id',$dados[3])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
				$handlesDisp = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('importacao_id',$dados[3])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
				$handlesCar = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',12);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('importacao_id',$dados[3])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
			}

			foreach($handles as $handle){
				$qtdDisp = 0;
				$Carregados = 0;
				$Total = 0;
				if(!empty($handlesDisp->first()->id)){
					foreach($handlesDisp as $Disp){
						if($handle->MAR_PEZ == $Disp->MAR_PEZ && $handle->estagio_id == $Disp->estagio_id){
							$qtdDisp = $Disp->qtd;
						}
					}
				}
				if(!empty($handlesCar->first()->qtd)){
					foreach($handlesCar as $Car){
						if($handle->MAR_PEZ == $Car->MAR_PEZ){
							$Carregados = $Car->qtd;
						}
					}
				}
				if(!empty($handlesTotal->first()->qtd)){
					foreach($handlesTotal as $Tot){
						if($handle->MAR_PEZ == $Tot->MAR_PEZ){
							$Total = $Tot->qtd;
						}
					}
				}



				if($dados[4] == 1){
					if($qtdDisp != 0){
						
						$lote = !empty($handle->lote->descricao) ? $handle->lote->descricao : '-';
						$data[] = array(
						'select-checkbox' => '',
						'qtd' => "<input type='number' onkeydown='return false' class='row-qtd input-sm form-control' name='qtd&&".$handle->id."&".$handle->id."' value='' min='0' max='".$qtdDisp."' placeholder='".$qtdDisp."'>",
						'lote' => $lote,
						'estagio' => $handle->estagio->descricao,
						'conjunto' => $handle->MAR_PEZ,
						'tipologia' => $handle->DES_PEZ,
						'tratamento' => $handle->TRA_PEZ,
						'icone' => "<img class='tooltipo'  data-placement='right' data-toggle='tooltip' data-html='true' title='".$handle->DES_PEZ."' src='".asset('img/icons/'.getIcon($handle->DES_PEZ))."''>",
						'peso' => number_format($handle->PUN_LIS, 2, ',','.'),
						'total' => $Total,
						'carregado' => $Carregados,
						'saldo' => $qtdDisp,
						);
					}
				}else{
					$lote = !empty($handle->lote->descricao) ? $handle->lote->descricao : '-';
					$estagi = !empty($handle->estagio->descricao) ? $handle->estagio->descricao : '-';
					$data[] = array(
					'select-checkbox' => '',
					'qtd' => "<input type='number' onkeydown='return false' class='row-qtd input-sm form-control' name='qtd&&".$handle->id."&".$handle->id."' value='' min='0' max='".$qtdDisp."' placeholder='".$qtdDisp."'>",
					'lote' => $lote,
					'estagio' => $handle->estagio->descricao,
					'conjunto' => $handle->MAR_PEZ,
					'tipologia' => $handle->DES_PEZ,
					'tratamento' => $handle->TRA_PEZ,
					'icone' => "<img class='tooltipo'  data-placement='right' data-toggle='tooltip' data-html='true' title='".$handle->DES_PEZ."' src='".asset('img/icons/'.getIcon($handle->DES_PEZ))."''>",
					'peso' => number_format($handle->PUN_LIS, 2, ',','.'),
					'total' => $Total,
					'carregado' => $Carregados,
					'saldo' => $qtdDisp,
					);
				}
			}
		}
		$total = empty($handles) ? 0 : $handles->count();
		$response['data'] =  $data;
		$response['current'] = 1;
		$response['rowCount'] = 11;
		$response['total'] = $total;

			
		return json_encode($response);
	}

	public function getConjuntosRomaneio($id){
		$romaneio = rom::find($id);

		$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('romaneio_id',$id)->where('FLG_REC', 3)->groupBy('MAR_PEZ')->groupBy('etapa_id')->get();
		if(!empty($handles->first()->id)){
			foreach($handles as $handle){
			$qtd = ($romaneio->status == 'Fechado') ? $handle->qtd : "<input type='number' onkeydown='return false' class='row-qtd input-sm form-control' name='qtd&&".$handle->id."&".$handle->id."' value='' min='0' max='".$handle->qtd."' placeholder='".$handle->qtd."'>";
			$data[] = array(
				'select-checkbox' => '',
				'qtd' => $qtd,
				'conjunto' => $handle->MAR_PEZ,
				'etapaID' => $handle->etapa_id,
				'etapa'  => $handle->etapa->codigo,
				'lote' => $handle->lote->descricao,
				'estagio' => $handle->estagio->descricao,
				'peso' => number_format($handle->PUN_LIS, 2, ',','.'),
				'tipologia' => $handle->DES_PEZ,
				'icone' => "<img class='tooltipo'  data-placement='right' data-toggle='tooltip' data-html='true' title='".$handle->DES_PEZ."' src='".asset('img/icons/'.getIcon($handle->DES_PEZ))."''>",
				'tratamento' => $handle->TRA_PEZ,
				);
		}
	}else{
		$data = array('' => '');
	}
		
		$response['data'] =  $data;
		return json_encode($response);
	}

	public function gravar(Request $request){
		$recordeds = array();
		$xc = 0;
        $dados = $request->all();
        $romaneios = explode('&', urldecode($dados['romaneio']));
        $rom = array();
        foreach($romaneios as $romaneio){
	        $check2 = explode('=',$romaneio);
	        if($check2[1] != ''){
	        	$rom[] = $romaneio;
	        }
        } 

        $Romaneio = array('RNfs' => '');
        $cc = false;
        foreach($rom as $roma){
        	$rima = explode('=', $roma);
        	if($rima[0] == 'Rnf[]'){
        		if($cc == true)
        			$Romaneio['RNfs'] .= ','.$rima[1];
        		else
        			$Romaneio['RNfs'] .= $rima[1];
        		$cc = true;
        	}else{
        		$Romaneio[$rima[0]] = $rima[1];
        	}
        }
        $romanei = array();
        $transp = array();
        $motora = array();
        foreach($Romaneio as $key => $Romo){
        	if($key[0] == 'R'){
        		$temp = strtolower(substr($key, 1));
        		if($temp == 'obra' || $temp == 'etapa' || $temp == 'subetapa')
        			$temp .= '_id';
        		if($temp == 'saida')
        			$temp = 'data_saida';
        		if($temp == 'previsao')
        			$temp = 'previsao_chegada';
        	$romanei[$temp] = $Romo;
        	}elseif($key[0] == 'T'){
        		$temp = strtolower(substr($key, 1));
        		if($temp == 'ranid')
        			$temp = 'id';
        		$transp[$temp] = $Romo;
        	}elseif($key[0] == 'M'){
        		$temp = strtolower(substr($key, 1));
        		if($temp == 'otid')
        			$temp = 'id';
        		$motora[$temp] = $Romo;
        	}
        }
        $romanei['locatario_id'] =access()->user()->locatario_id;
        $romanei['status'] = 'Aberto';
        $romanei['user_id']   =access()->user()->id;
        $romanei['transportadora_id'] = $this->handleTrans($transp);
        $romanei['motorista_id'] = $this->handleMot($motora);
        if(!empty($romanei['obs']))
        $romanei['observacoes'] = $romanei['obs'];
    	if(!empty($romanei['nfs']))
        $romanei['Nfs'] = $romanei['nfs'];
        $newRom = rom::create($romanei);

        // $newEstage = est::where('tipo',11)->first();
        $msg = 'Criação de Romaneio: '. $newRom->codigo;

        // if(!empty($dados['handles'][0])){


	 //        foreach($dados['handles'] as $cjt => $qtd){
	 //   //      	$cjto = handle::where('MAR_PEZ', $cjt)->where('FLG_REC', 3)->whereHas('estagio', function($q){
		// 		// 		$q->where('tipo',3);
		// 		// 	})->where('subetapa_id', $newRom->subetapa_id)->first();
	 //   //      	if($cjto->importacao->sentido == 1){
		// 		// 	$x = 'ASC'; $y='ASC';
		// 		// }elseif($cjto->importacao->sentido == 2){
		// 		// 	$x = 'DESC'; $y = 'ASC';
		// 		// }elseif($cjto->importacao->sentido == 3){
		// 		// 	$x = 'DESC'; $y = 'DESC';
		// 		// }elseif($cjto->importacao->sentido == 4){
		// 		// 	$x = 'ASC'; $y = 'DESC';
		// 		// }
		// 		// $putRom = handle::where('MAR_PEZ',$cjto->MAR_PEZ)->where('FLG_REC', 3)->whereHas('estagio', function($q){
		// 		// 		$q->where('tipo',3);
		// 		// 	})->where('subetapa_id', $newRom->subetapa_id)->orderBy('X', $x)->orderBy('Y', $y)->take($qtd);
		// 		$putRom = handle::where('MAR_PEZ',$cjto->MAR_PEZ)->where('FLG_REC', 3)->whereHas('estagio', function($q){
		// 		 		$q->where('tipo',3);
		// 		 	})->take($qtd);
		// 		$toRecord = $putRom->get();
				
		// 			$recordeds[$xc]['MAR_PEZ'] = $toRecord->first()->MAR_PEZ;
		// 			$recordeds[$xc]['qtd'] = $dados['handles'][$toRecord->first()->MAR_PEZ];
		// 			$xc++;

		// 		$valtoUpdate = ['romaneio_id' => $newRom->id, 'estagio_id' => $newEstage->id];
		// 		$putRom->update($valtoUpdate);
		// 		$msg .= ' Conjuntos: ';
				
	 //        }

	 //        foreach($recordeds as $don){
		// 			$msg .= $don['MAR_PEZ'].' - Qtd: ' .$don['qtd']. ' -- ';
		// 		}
		// }
			$msg .='. Realizado por '. access()->user()->name .'.';
            Log::info($msg);
            \Session::flash('flash_success', 'Romaneio Criado com Sucesso!');
            return $newRom->id;
	}

	public function update(Request $request){
		$dados = $request->all();
		$romaneios = explode('&', urldecode($dados['romaneio']));
        $rom = array();
        foreach($romaneios as $romaneio){
	        $check2 = explode('=',$romaneio);
	        if($check2[1] != ''){
	        	$rom[] = $romaneio;
	        }
        } 

        $Romaneio = array('RNfs' => '');
        $cc = false;
        foreach($rom as $roma){
        	$rima = explode('=', $roma);
        	if($rima[0] == 'Rnf[]'){
        		if($cc == true)
        			$Romaneio['RNfs'] .= ','.$rima[1];
        		else
        			$Romaneio['RNfs'] .= $rima[1];
        		$cc = true;
        	}else{
        		$Romaneio[$rima[0]] = $rima[1];
        	}
        }
        $romanei = array();
        $transp = array();
        $motora = array();
        foreach($Romaneio as $key => $Romo){
        	if($key[0] == 'R'){
        		$temp = strtolower(substr($key, 1));
        		if($temp == 'obra' || $temp == 'etapa' || $temp == 'subetapa')
        			$temp .= '_id';
        		if($temp == 'saida')
        			$temp = 'data_saida';
        		if($temp == 'previsao')
        			$temp = 'previsao_chegada';
        	$romanei[$temp] = $Romo;
        	}elseif($key[0] == 'T'){
        		$temp = strtolower(substr($key, 1));
        		if($temp == 'ranid')
        			$temp = 'id';
        		$transp[$temp] = $Romo;
        	}elseif($key[0] == 'M'){
        		$temp = strtolower(substr($key, 1));
        		if($temp == 'otid')
        			$temp = 'id';
        		$motora[$temp] = $Romo;
        	}
        }
        $romanei['transportadora_id'] = $this->handleTrans($transp);
        $romanei['motorista_id'] = $this->handleMot($motora);
        if(!empty($romanei['obs']))
        $romanei['observacoes'] = $romanei['obs'];
        if(!empty($romanei['nfs']))
        $romanei['Nfs'] = $romanei['nfs'];
        $newRom = rom::find($dados['id'])->update($romanei);
        if($newRom) return 'Romaneio Atualizado com Sucesso!&alert-success';
        else return 'Erro ao Atualizar Romaneio.&alert-danger';
	}

	public function adicionar(Request $request){
		 $dados = $request->all(); 
		 $doEtapa = true;
		 $etapaID = $dados['etapaID'];
		
		 $etapa = etap::find($etapaID);
		 $newEstage = est::where('tipo',11)->first();
		 $newRom = rom::find($dados['id']);
		 $etapasIds = array();
		 foreach($newRom->etapas as $etapaX){
		 	$etapasIds[] = $etapaX->id;
		 }
		 
		 $xc = 0;
		 foreach($dados['handles'] as $cjt => $qtd){
		 	if(!empty($qtd)){
	 			if(!in_array($etapaID, $etapasIds) && $doEtapa==true){
				 	$newRom->etapas()->attach($etapa);
				 	$doEtapa = false;
				 }
		 		$cjto = handle::where('MAR_PEZ', $cjt)->where('FLG_REC', 3)->where('etapa_id', $etapa->id)->first();

         	if($cjto->importacao->sentido == 1){
				$x = 'ASC'; $y='ASC';
			}elseif($cjto->importacao->sentido == 2){
				$x = 'DESC'; $y = 'ASC';
			}elseif($cjto->importacao->sentido == 3){
				$x = 'DESC'; $y = 'DESC';
			}elseif($cjto->importacao->sentido == 4){
				$x = 'ASC'; $y = 'DESC';
			}
			$putRom = handle::where('MAR_PEZ',$cjt)->where('FLG_REC', 3)->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('etapa_id', $etapa->id)->orderBy('X', $x)->orderBy('Y', $y)->take($qtd);

			$toRecord = $putRom->get();
				$recordeds[$xc]['MAR_PEZ'] = $toRecord->first()->MAR_PEZ;
				$recordeds[$xc]['qtd'] = $dados['handles'][$toRecord->first()->MAR_PEZ];
				$xc++;

			$valtoUpdate = ['romaneio_id' => $newRom->id, 'estagio_id' => $newEstage->id];
			$putRom->update($valtoUpdate);
		 	}
        		
        }

        if($xc == 0)
        	return 'Nenhum Conjunto Selecionado&alert-warning';

        $msg =  'Conjuntos: ';

        foreach($recordeds as $don){
				$msg .= $don['MAR_PEZ'].' - Qtd: ' .$don['qtd']. ' -- ';
			}
			$msg .='Adicionados ao Romaneio: '. $newRom->codigo.'. Realizado por '. access()->user()->name .'.';
            Log::info($msg);
            return 'Conjuntos Adicionados a '.$newRom->codigo.' com Sucesso!&alert-success';
	}

	public function remover(Request $request){
		 $dados = $request->all(); 
		 $newEstage = est::where('tipo',3)->first();
		 $newRom = rom::find($dados['id']);
		 foreach($newRom->etapas as $etapaX){
		 	$etapasIds[] = $etapaX->id;
		 }
		 $xc = 0;
		 foreach($dados['handles'] as $cjt){
		 	if(!empty($cjt['qtd'])){
		$cjto = handle::where('MAR_PEZ', $cjt['handles'])->where('FLG_REC', 3)->where('etapa_id',$cjt['etapa'])->where('romaneio_id', $newRom->id)->first();
        	if($cjto->importacao->sentido == 1){
				$x = 'DESC'; $y='DESC';
			}elseif($cjto->importacao->sentido == 2){
				$x = 'ASC'; $y = 'DESC';
			}elseif($cjto->importacao->sentido == 3){
				$x = 'ASC'; $y = 'ASC';
			}elseif($cjto->importacao->sentido == 4){
				$x = 'DESC'; $y = 'ASC';
			}
			$putRom = handle::where('MAR_PEZ',$cjt['handles'])->where('FLG_REC', 3)->where('etapa_id',$cjt['etapa'])->where('romaneio_id', $newRom->id)->orderBy('X', $x)->orderBy('Y', $y)->take($cjt['qtd']);

			$toRecord = $putRom->get();
				$recordeds[$xc]['MAR_PEZ'] = $toRecord->first()->MAR_PEZ;
				$recordeds[$xc]['qtd'] = $cjt['qtd'];
				$xc++;

			$valtoUpdate = ['romaneio_id' => null, 'estagio_id' => $newEstage->id];
			$putRom->update($valtoUpdate);
		 	}
        		
        }

        if($xc == 0){
        	return 'Nenhum Conjunto Selecionado&alert-warning';
        }else{
        	$newEtapas = array();
        	$newnewRom = rom::find($dados['id']);
        	if(isset($newnewRom->handles->first()->id)){
        		 foreach($newnewRom->handles as $handloca){
        		 	if(!in_array($handloca->etapa_id, $newEtapas))
        	 			$newEtapas[] = $handloca->etapa_id;
			 }
        	}
        	if(isset($etapasIds) && !empty($etapasIds)){
        		 foreach($etapasIds as $eid){
				 	if(!in_array($eid, $newEtapas)){
				 		$etapaGone = etap::find($eid);
				 		$newnewRom->etapas()->detach($etapaGone);
				 	}
			 	}
        	}
			
        }
        	

        $msg =  'Conjuntos: ';

        foreach($recordeds as $don){
				$msg .= $don['MAR_PEZ'].' - Qtd: ' .$don['qtd']. ' -- ';
			}
			$msg .='Removidos do Romaneio: '. $newRom->codigo.'. Realizado por '. access()->user()->name .'.';
            Log::info($msg);
            return 'Conjuntos Removidos de '.$newRom->codigo.' com Sucesso!&alert-success';
	}

	public function fechar($id){
		$romaneio = rom::find($id);
		if(empty($romaneio->handles->first()->id))
			return redirect()->back()->withFlashWarning('Romaneio sem Conjuntos não podem ser fechados.');
		else{
			$newEstage = est::select('id')->where('tipo',12)->first();
			$status = array('status' => 'Fechado');
			$update = rom::find($id)->update($status);
			$estagio = array('estagio_id' => $newEstage->id);
			foreach( $romaneio->handles as $handles){
				$handles->update($estagio);
			}

			if(isset($update))
				return redirect()->back()->withFlashSuccess('Romaneio Fechado com Sucesso!');
			else
				return redirect()->back()->withFlashDanger('Erro ao Fechar Romaneio!');
			
		}
	}

	public function excluir($id){
		$romaneio = rom::find($id);
		$romaneio->etapas()->detach();
		$newEstage = est::select('id')->where('tipo',3)->first();
		$updateData = array('estagio_id' => $newEstage->id, 'romaneio_id', null);
		foreach($romaneio->handles as $handle){
			$handle->update($updateData);
		}
		
        $msg =  'Romaneio Removido: '.$romaneio->codigo.'. Realizado por: '.access()->user()->name .'.';
        $romaneio->delete();
         Log::info($msg);
         return redirect('romaneios')->withFlashSuccess('Romaneio Excluido com Sucesso!');
	}

	public function pdf($id){
		 $romaneio = rom::find($id);
		 $pesoTotal = 0;
		 foreach($romaneio->handles as $handle){
		 	if($handle->FLG_REC == 3){
		 		$pesoTotal = $handle->PUN_LIS + $pesoTotal;
		 	}
		 }
		$parameter['handles'] =  handle::selectRaw('*, sum(QTA_PEZ) as qtd, sum(PUN_LIS) as peso')->where('romaneio_id',$romaneio->id)->where('FLG_REC', 3)->groupBy('MAR_PEZ')->get();
		$parameter['pesoTotal'] = $pesoTotal;
		$parameter['romaneio'] = $romaneio;
		$parameter['title'] = $romaneio->codigo;
		$pdf = PDF::loadView('romaneios::pdf', $parameter);
        return $pdf->stream( $parameter['title']);
	}

	private function handleTrans($trans){
		$transps = tran::all();
		$names = array();
		foreach($transps as $tra){
			$names[] = $tra->nome;
		}
		if(!empty($trans['obs']))
			$trans['observacoes'] = $trans['obs'];
		if(!in_array($trans['nome'], $names)){
			unset($trans['id']);
			$trans['locatario_id'] =access()->user()->locatario_id;
        	$trans['user_id']   =access()->user()->id;
			$tr = tran::create($trans);
			return $tr->id;
		}else{
			unset($trans['id']);
			$trid = tran::where('nome',$trans['nome'])->first();
			$tr = $trid->id;
			$trid->update($trans);
			return $tr;
		}
	}

	private function handleMot($trans){
		$transps = mot::all();
		$names = array();
		foreach($transps as $tra){
			$names[] = $tra->nome;
		}
		if(!empty($trans['obs']))
			$trans['observacoes'] = $trans['obs'];
		if(!in_array($trans['nome'], $names)){
			unset($trans['id']);
			$trans['locatario_id'] =access()->user()->locatario_id;
        	$trans['user_id']   =access()->user()->id;
			$tr = mot::create($trans);
			return $tr->id;
		}else{
			unset($trans['id']);
			$trid = mot::where('nome',$trans['nome'])->first();
			$tr = $trid->id;
			$trid->update($trans);
			return $tr;
		}
	}
	
}