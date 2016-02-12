<?php namespace Modules\Apontador\Http\Controllers;


use Illuminate\Http\Request;
use App\Obra as obr;
use App\Etapa as etap;
use App\Subetapa as sub;
use App\Importacao as imp;
use App\Handle as handle;
use App\Estagio as est;
use App\Lote as lote;
use App\Cronograma as cron;
use App\CronogramaReal as creal;
use Pingpong\Modules\Routing\Controller;
use Log;

class ApontadorController extends Controller {
	
	public function index()
	{
        $obras = obr::all(); 
        if(\Session::get('history')){
        	
        	$ids = (\Session::get('history'));
        	if($ids['lID'] == 0)
        		$conjuntos = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('subetapa_id',$ids['sID'])->where('FLG_REC',3)->groupBy('MAR_PEZ')->groupBy('lote_id')->get();
        	else
        		$conjuntos = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('subetapa_id',$ids['sID'])->where('FLG_REC',3)->where('lote_id', $ids['lID'])->groupBy('MAR_PEZ')->groupBy('lote_id')->get();

        	$estagios = est::where('tipo', 2)->orderBy('ordem','asc')->get();
            $etapa = etap::find($ids['eID']);
            $etapas = etap::where('obra_id',$etapa->obra_id)->get();
            $thisSubetapa = sub::find($ids['sID']);
            $subetapas = sub::where('etapa_id', $ids['eID'])->get();
            $thisLote = lote::find($ids['lID']);
            $lotes = lote::where('subetapa_id', $ids['sID'])->get();
            $history = true;
            return view('apontador::index',compact('obras', 'etapas', 'etapa', 'history','conjuntos','estagios', 'subetapas', 'thisSubetapa', 'lotes', 'thisLote'));
        }
		return view('apontador::index', compact('obras'));
	}

	public function printInputs($conjunto_id){
		$conjunto = handle::find($conjunto_id);
		$estagios = est::where('tipo',2)->orderBy('ordem','asc')->get();
		if(isset($conjunto->lote->descricao)){
			$estags = array();
			foreach($conjunto->lote->cronogramas as $cronos){
				$estags[] = $cronos->estagio_id;
			}	

			foreach($estagios as $estagio){

				if(in_array($estagio->id, $estags)){

					$qtd = handle::where('lote_id', $conjunto->lote_id)->where('estagio_id', $estagio->id)->where('MAR_PEZ', $conjunto->MAR_PEZ)->sum('QTA_PEZ');

					$estg =  handle::where('lote_id', $conjunto->lote_id)->where('estagio_id', '>', $estagio->id)->where('MAR_PEZ', $conjunto->MAR_PEZ)->get();
					$estgMenor =  handle::where('lote_id', $conjunto->lote_id)->where('estagio_id', '<=', $estagio->id)->where('MAR_PEZ', $conjunto->MAR_PEZ)->get();

					$ended = false;
					$mustDoIt = true;

					if(!empty($estg->first()->id) && (empty($estgMenor->first()->id) || $qtd < 1)){

						$dataR = creal::where('lote_id', $conjunto->lote_id)->where('estagio_id', $estagio->id)->where('MAR_PEZ', $conjunto->MAR_PEZ)->orderBy('data', 'desc')->get();

						if(!empty($dataR->first()->data)){

							$mustDoIt = false;

							echo " <td><p class='form-control-static'>0</p></td>
		                    <td><p class=' form-control-static'>".date('d/m/Y',strtotime($dataR->first()->data))."</p></td> ";
						}

					}
					if($mustDoIt == true){
						if($qtd < 1){
							echo "<td><p class=' form-control-static'>0</p></td>
								  <td><p class=' form-control-static'>dd/mm/aaaa</p></td>";
						}else{
							$today = date('Y-m-d');
							echo " <td><input type='number' onkeydown='return false' class='row-qtd input-sm form-control' name='qtd&&".$estagio->id."&".$conjunto->id."' value='' min='0' max='".$qtd."' placeholder='".$qtd."' style='line-height:15px'></td>
	                    <td><input type='date' class='row-date input-sm form-control' name='date&&".$estagio->id."&".$conjunto->id."' style='line-height:15px' value='".$today."'></td> ";
						}		
					}

					
				}else{
					echo '<td></td>
	                	<td></td>'; 
				}
			}
	 		   
		}else{
			foreach($estagios as $estagio){
			echo '<td></td>
            	<td></td>'; 
            }
		}
	}

	public function setHistory(Request $request){
		$dados = $request->all();
		 if(\Session::get('ApWarning'))
			\Session::forget('ApWarning');
		if(\Session::get('ApDanger'))
			\Session::forget('ApDanger');
		if(\Session::get('ApSuccess'))
			\Session::forget('ApSuccess');
		if(!empty($dados['erro'])){
			list($msg, $tipo) = explode('&', $dados['erro']);
    		\Session::put($tipo, $msg);
    	}
		\Session::flash('history', $dados);
		return route('apontador');
	}

	public function apontar(Request $request){
		$dados = $request->all();
		$dados = explode('&xXx&', $dados['dados']);

		$data = array();
		$warnings = array();
		$done = array();
		foreach($dados as $newDados){
			$haveStuff = substr($newDados, -1);
			if($haveStuff != '='){
				$data[] = $newDados;
			}
		}

		if(count($data) < 1){
			return 'Nenhum Dado Informado.&ApDanger';
		}
		$dates = array();
		$qtdds = array();
		$qtdKey = array();
		$qtds = array();
		$recordeds = array();
		foreach($data as $dat){
			list($tip, $inf) = explode('&&', $dat);
			if($tip == 'date'){
				$check = explode('=', $inf);
				$dates[] = $check[0];
			}
			if($tip == 'qtd'){
				$checko = explode('=', $inf);
				$qtdKey[] = $checko[0];
				$qtdds[] = $checko[1];
				$qtds[$checko[0]] = $checko[1];
			}
		}


		for($cco = 0;$cco < count($qtdds);$cco++){
			if($qtdds[$cco] == 0 ){
				unset($qtdds[$cco]);
			}
		}

		if(count($qtdds) < 1){
			return 'Nenhum Dado Informado.&ApDanger';
		}

		foreach($data as $dat){
			list($type, $info) = explode('&&', $dat);
			if($type == 'qtd' || $type == 'date' ){
				list($estagioId, $moreInfo) = explode('&', $info);
				list($conjuntoId, $value) = explode('=', $moreInfo);
				$ThisEst = est::find($estagioId);
				$conj = handle::find($conjuntoId);
				$estagios = array();
				foreach($conj->lote->cronogramas as $crono){
					$estagios[] = $crono->estagio_id;
				}
				

				if($type == 'qtd'){
					$chc = explode('=',$info);
					if(!in_array($chc[0], $dates)){
						$warnings[] = "O Conjunto: ".$conj->MAR_PEZ.", Estagio - ".$conj->estagio->descricao.", Quantidade - ".$value." - Não foi apontado, pois a Data Realizada  não foi informada.";
					}else{
						if($conj->importacao->sentido == 1){
						$x = 'ASC'; $y='ASC';
					}elseif($conj->importacao->sentido == 2){
						$x = 'DESC'; $y = 'ASC';
					}elseif($conj->importacao->sentido == 3){
						$x = 'DESC'; $y = 'DESC';
					}elseif($conj->importacao->sentido == 4){
						$x = 'ASC'; $y = 'DESC';
					}else{
						return 'Falha ao Procurar Sentido de Construção.&ApDanger';
					}
					if($estagioId == end($estagios)){
						$newEstagio = $conj->estagio_id;
						$doIt = 0;
					}else{
						$doIt = 1;
					}
					
					for($count = 0; $count<count($estagios);$count++){
						if($estagioId == $estagios[$count] && $doIt == 1){
							$newEstagio = $estagios[++$count];
							$doIt = 0;
						}
					}

					$upEstagio = ['estagio_id' => $newEstagio];
					$update = handle::where('lote_id', $conj->lote_id)->where('MAR_PEZ',$conj->MAR_PEZ)->where('estagio_id', $estagioId)->orderBy('X', $x)->orderBy('Y', $y)->take($value);
					$toRecord = $update->get();
					foreach($toRecord as $recor){
						$recordeds[$chc[0]][] = $recor->id;
					}

					$update->update($upEstagio);
					$done[] = $conj->MAR_PEZ.'&'.$ThisEst->descricao.'&'.$conj->lote->descricao.'&'.$value;

					}
					
				}elseif($type == 'date'){
					$chcc = explode('=',$info);
					

					if(in_array($chcc[0], $qtdKey)){

							if($conj->importacao->sentido == 1){
							$x = 'ASC'; $y='ASC';
						}elseif($conj->importacao->sentido == 2){
							$x = 'DESC'; $y = 'ASC';
						}elseif($conj->importacao->sentido == 3){
							$x = 'DESC'; $y = 'DESC';
						}elseif($conj->importacao->sentido == 4){
							$x = 'ASC'; $y = 'DESC';
						}
					//	$Take = (int) $qtds[$chcc[0]];
						$RecordsID = $recordeds[$chcc[0]];
						$updateData = handle::where('lote_id', $conj->lote_id)->where('MAR_PEZ',$conj->MAR_PEZ)->where('estagio_id', $newEstagio)->get();

						foreach($updateData as $upDat){

							if(in_array($upDat->id, $RecordsID)){
								$dataReal = [
									'estagio_id' 	=>  $estagioId,
									'lote_id'    	=>  $upDat->lote_id,
									'handle_id'  	=>  $upDat->id,
									'MAR_PEZ' 	 	=>  $upDat->MAR_PEZ,
									'data'       	=>  $value,
									'user_id'    	=>  access()->user()->id,
									'locatario_id'  =>  access()->user()->locatario_id
								];

								$Creal = creal::create($dataReal);
							}

							
						}
						

					}

				}
			}else{
				return 'Erro ao Realizar Apontamento.&ApDanger';
			}
		}
		if(!empty(count($warnings))){
			$toReturn = '';
			foreach($warnings as $warn){
				$toReturn .= $warn."</br>";
			}
			$toReturn .="&ApWarning";
			return $toReturn;
		}else{
			$msg = 'Apontamento: ';
			foreach($done as $donee){
				$don = explode('&', $donee);
				$msg .= 'Conjunto: '.$don[0].' - Quantidade: ' .$don[3]. ' - Estagio: '.$don[1].' - Lote: '.$don[2].' -- ';
			}
			$msg .=' Realizado por '. access()->user()->name .'.';
            Log::info($msg);
			return 'Apontamento Executado com Sucesso.&ApSuccess';
		}
	}

	
}