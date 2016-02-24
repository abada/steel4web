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

class RomaneiosController extends Controller {
	
	public function index()
	{
		$obras = obr::has('importacoes')->where('status',1)->get(); 
		if(\Session::get('history')){

        	$ids = (\Session::get('history'));
        	if($ids['eID'] == 0)
        		$romaneios = rom::where('obra_id',$ids['oID'])->get();
        	elseif($ids['sID'] == 0)
        		$romaneios = rom::where('etapa_id',$ids['eID'])->get();
        	else
        		$romaneios = rom::where('subetapa_id',$ids['sID'])->get();

        	$obraID = $ids['oID'];
        	$obraID = $ids['oID'];
        	$etapas = etap::has('importacoes')->where('obra_id',$ids['oID'])->get();
        	if($ids['eID'] != 0){
				$etapa = etap::find($ids['eID']);
           	    $subetapas = sub::has('importacoes')->where('etapa_id', $ids['eID'])->get();
			}else{
				$etapa = null;
				$subetapas = null;
			}

			if($ids['sID'] != 0){
				$thisSubetapa = sub::find($ids['sID']);
            	$importacoes = imp::where('subetapa_id', $ids['sID'])->get();
			}else{
				$thisSubetapa = null;
				$importacoes = null;
			}
        
            
            $history = true;
            return view('romaneios::index',compact('obras','obraID', 'etapas', 'romaneios','history','etapas', 'etapa','subetapas', 'thisSubetapa'));
        }
		return view('romaneios::index', compact('obras'));
	}

	public function setHistory(Request $request){
		$dados = $request->all();
		\Session::flash('history', $dados);
		return route('romaneios');
	}

	public function perfil($id){
		$obras = obr::has('importacoes')->where('status',1)->get(); 
		$romaneio = rom::find($id);
		$editar = false;
		$perfil = true;
		$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('romaneio_id',$id)->where('FLG_REC', 3)->groupBy('MAR_PEZ')->get();
		 
		if($romaneio->status != 'Fechado'){
			$handles = 0;
			$editar = true;
			$perfil = false;
		}
		return view('romaneios::criar', compact('obras','romaneio','editar','perfil','handles'));
	}

	public function criar(){
		$obras = obr::has('importacoes')->where('status',1)->get(); 
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
			if(empty($dados[2])){
				$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('FLG_REC', 3)->has('lote')->groupBy('MAR_PEZ')->groupBy('estagio_id')->get();
				$handlesDisp = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->groupBy('estagio_id')->get();
				$handlesCar = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',4);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->groupBy('estagio_id')->get();
			}elseif(empty($dados[3])){
				$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->has('lote')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
				$handlesDisp = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
				$handlesCar = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',4);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
			}else{
				$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->has('lote')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('importacao_id',$dados[3])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
				$handlesDisp = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('importacao_id',$dados[3])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
				$handlesCar = handle::selectRaw('*,sum(QTA_PEZ) as qtd')->whereHas('estagio', function($q){
					$q->where('tipo',4);
				})->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('importacao_id',$dados[3])->where('FLG_REC', 3)->groupBy('estagio_id')->groupBy('MAR_PEZ')->get();
			}

			foreach($handles as $handle){
				$qtdDisp = 0;
				if(!empty($handlesDisp->first()->id)){
					foreach($handlesDisp as $Disp){
						if($handle->MAR_PEZ == $Disp->MAR_PEZ && $handle->estagio_id == $Disp->estagio_id){
							$qtdDisp = $Disp->qtd;
						}
					}
				}
				$Carregados = !empty($handlesCar->qtd) ? $handlesCar->qtd : 0;
				if($dados[4] == 1){
					if($qtdDisp != 0){
						
						$lote = !empty($handle->lote->descricao) ? $handle->lote->descricao : '-';
						$data[] = array(
						'select-checkbox' => '',
						'qtd' => "<input type='number' onkeydown='return false' class='row-qtd input-sm form-control' name='qtd&&".$handle->id."&".$handle->id."' value='' min='0' max='".$qtdDisp."' placeholder='".$qtdDisp."'>",
						'lote' => $lote,
						'estagio' => $handle->estagio->descricao,
						'conjunto' => $handle->MAR_PEZ,
						'descricao' => "<img class='tooltipo'  data-placement='right' data-toggle='tooltip' data-html='true' title='".$handle->DES_PEZ."' src='".asset('img/icons/'.getIcon($handle->DES_PEZ))."''>",
						'tratamento' => $handle->TRA_PEZ,
						'total' => $handle->qtd,
						'carregado' => $Carregados,
						'saldo' => ($qtdDisp - $Carregados),
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
					'descricao' => "<img class='tooltipo'  data-placement='right' data-toggle='tooltip' data-html='true' title='".$handle->DES_PEZ."' src='".asset('img/icons/'.getIcon($handle->DES_PEZ))."''>",
					'tratamento' => $handle->TRA_PEZ,
					'total' => $handle->qtd,
					'carregado' => $Carregados,
					'saldo' => ($qtdDisp - $Carregados),
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

		$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('romaneio_id',$id)->where('FLG_REC', 3)->groupBy('MAR_PEZ')->get();
		
		foreach($handles as $handle){
			$qtd = ($romaneio->status == 'Fechado') ? $handle->qtd : "<input type='number' onkeydown='return false' class='row-qtd input-sm form-control' name='qtd&&".$handle->id."&".$handle->id."' value='' min='0' max='".$handle->qtd."' placeholder='".$handle->qtd."'>";
			$data[] = array(
				'select-checkbox' => '',
				'qtd' => $qtd,
				'conjunto' => $handle->MAR_PEZ,
				'lote' => $handle->lote->descricao,
				'estagio' => $handle->estagio->descricao,
				'descricao' => "<img class='tooltipo'  data-placement='right' data-toggle='tooltip' data-html='true' title='".$handle->DES_PEZ."' src='".asset('img/icons/'.getIcon($handle->DES_PEZ))."''>",
				'tratamento' => $handle->TRA_PEZ,
				);
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
        $romanei['user_id']   =access()->user()->id;
        $romanei['transportadora_id'] = $this->handleTrans($transp);
        $romanei['motorista_id'] = $this->handleMot($motora);
        $newRom = rom::create($romanei);
        $newEstage = est::where('tipo',4)->first();

        foreach($dados['handles'] as $cjt => $qtd){
        	$cjto = handle::where('MAR_PEZ', $cjt)->where('FLG_REC', 3)->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('subetapa_id', $newRom->subetapa_id)->first();
        	if($cjto->importacao->sentido == 1){
				$x = 'ASC'; $y='ASC';
			}elseif($cjto->importacao->sentido == 2){
				$x = 'DESC'; $y = 'ASC';
			}elseif($cjto->importacao->sentido == 3){
				$x = 'DESC'; $y = 'DESC';
			}elseif($cjto->importacao->sentido == 4){
				$x = 'ASC'; $y = 'DESC';
			}
			$putRom = handle::where('MAR_PEZ',$cjto->MAR_PEZ)->where('FLG_REC', 3)->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('subetapa_id', $newRom->subetapa_id)->orderBy('X', $x)->orderBy('Y', $y)->take($qtd);
			$toRecord = $putRom->get();
			
				$recordeds[$xc]['MAR_PEZ'] = $toRecord->first()->MAR_PEZ;
				$recordeds[$xc]['qtd'] = $dados['handles'][$toRecord->first()->MAR_PEZ];
				$xc++;

			$valtoUpdate = ['romaneio_id' => $newRom->id, 'estagio_id' => $newEstage->id];
			$putRom->update($valtoUpdate);
			$msg = 'Romaneio: '. $newRom->codigo.'. Conjuntos: ';
			
        }

        foreach($recordeds as $don){
				$msg .= $don['MAR_PEZ'].' - Qtd: ' .$don['qtd']. ' -- ';
			}
			$msg .=' Realizado por '. access()->user()->name .'.';
            Log::info($msg);
            return 'Romaneio Criado com Sucesso!';
	}

	public function adicionar(Request $request){
		 $dados = $request->all(); 
		 $newEstage = est::where('tipo',4)->first();
		 $newRom = rom::find($dados['id']);
		 $xc = 0;
		 foreach($dados['handles'] as $cjt => $qtd){
		 	if(!empty($qtd)){
		 		$cjto = handle::where('MAR_PEZ', $cjt)->where('FLG_REC', 3)->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('subetapa_id', $newRom->subetapa_id)->first();
        	if($cjto->importacao->sentido == 1){
				$x = 'ASC'; $y='ASC';
			}elseif($cjto->importacao->sentido == 2){
				$x = 'DESC'; $y = 'ASC';
			}elseif($cjto->importacao->sentido == 3){
				$x = 'DESC'; $y = 'DESC';
			}elseif($cjto->importacao->sentido == 4){
				$x = 'ASC'; $y = 'DESC';
			}
			$putRom = handle::where('MAR_PEZ',$cjto->MAR_PEZ)->where('FLG_REC', 3)->whereHas('estagio', function($q){
					$q->where('tipo',3);
				})->where('subetapa_id', $newRom->subetapa_id)->orderBy('X', $x)->orderBy('Y', $y)->take($qtd);
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
		 $xc = 0;
		 foreach($dados['handles'] as $cjt => $qtd){
		 	if(!empty($qtd)){
		 		$cjto = handle::where('MAR_PEZ', $cjt)->where('FLG_REC', 3)->whereHas('estagio', function($q){
					$q->where('tipo',4);
				})->where('subetapa_id', $newRom->subetapa_id)->first();
        	if($cjto->importacao->sentido == 1){
				$x = 'DESC'; $y='DESC';
			}elseif($cjto->importacao->sentido == 2){
				$x = 'ASC'; $y = 'DESC';
			}elseif($cjto->importacao->sentido == 3){
				$x = 'ASC'; $y = 'ASC';
			}elseif($cjto->importacao->sentido == 4){
				$x = 'DESC'; $y = 'ASC';
			}
			$putRom = handle::where('MAR_PEZ',$cjto->MAR_PEZ)->where('FLG_REC', 3)->where('romaneio_id', $newRom->id)->orderBy('X', $x)->orderBy('Y', $y)->take($qtd);
			$toRecord = $putRom->get();
			
				$recordeds[$xc]['MAR_PEZ'] = $toRecord->first()->MAR_PEZ;
				$recordeds[$xc]['qtd'] = $dados['handles'][$toRecord->first()->MAR_PEZ];
				$xc++;

			$valtoUpdate = ['romaneio_id' => null, 'estagio_id' => $newEstage->id];
			$putRom->update($valtoUpdate);
		 	}
        		
        }

        if($xc == 0)
        	return 'Nenhum Conjunto Selecionado&alert-warning';

        $msg =  'Conjuntos: ';

        foreach($recordeds as $don){
				$msg .= $don['MAR_PEZ'].' - Qtd: ' .$don['qtd']. ' -- ';
			}
			$msg .='Removidos do Romaneio: '. $newRom->codigo.'. Realizado por '. access()->user()->name .'.';
            Log::info($msg);
            return 'Conjuntos Removidos de '.$newRom->codigo.' com Sucesso!&alert-success';
	}

	private function handleTrans($trans){
		$transps = tran::all();
		$names = array();
		foreach($transps as $tra){
			$names[] = $tra->nome;
		}
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