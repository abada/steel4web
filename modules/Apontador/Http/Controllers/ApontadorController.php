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
use Pingpong\Modules\Routing\Controller;

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

					$estg =  handle::where('lote_id', $conjunto->lote_id)->where('estagio_id', $estagio->id)->get();
					$crono = cron::where('lote_id', $conjunto->lote_id)->where('estagio_id', $estagio->id)->get();

					$ended = false;

					// if(!empty($crono->first()->data_real)){

					// 	$ended = true;

					// 	// if(!empty($estg->first()->lote_id)){
					// 	// 	foreach($estg as $ets){
					// 	// 		echo $ets->estagio->ordem.' X '.$estagio->ordem.'x'.$estagio->descricao.'<br>';
					// 	// 		if($ets->estagio->ordem == $estagio->ordem){
					// 	// 			echo $ets->estagio_id.' X '.$estagio->id.'<br>';
					// 	// 			$ended = false;
					// 	// 		}
					// 	// 	}
					// 	// }
							
					// }
					if($ended == true){
						echo " <td><input min='0' max='0' style='line-height:15px' type='number' disabled value='0' style='line-height:15px'></td>
	                    <td><input style='line-height:15px' type='text' disabled style='line-height:15px' value='".date('d/m/Y',strtotime($crono->first()->data_real))."'></td> ";
					}else{
						$disable = ($qtd < 1) ? ' disabled ' : '';
						$today = ($qtd < 1) ? '' : date('Y-m-d');
						echo " <td><input type='number' ".$disable." onkeydown='return false' class='row-qtd' name='qtd&&".$estagio->id."&".$conjunto->id."' value='' min='0' max='".$qtd."' placeholder='".$qtd."' style='line-height:15px'></td>
	                    <td><input type='date' class='row-date' ".$disable." name='date&&".$estagio->id."&".$conjunto->id."' style='line-height:15px' value='".$today."'></td> ";
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
		$qtdds;
		foreach($data as $dat){
			list($tip, $inf) = explode('&&', $dat);
			if($tip == 'date'){
				$check = explode('=', $inf);
				$dates[] = $check[0];
			}
			if($tip == 'qtd'){
				$checko = explode('=', $inf);
				$qtdds['indice'][] = $checko[0];
				$qtdds['value'][] = $checko[1];
			}
		}
		
		for($cco = 0;$cco < count($qtdds);$cco++){
			if($qtdds['value'][$cco] == 0 ){
				foreach(array_keys($qtdds) as $key) {
				   unset($qtdds[$key][$cco]);
				}
			}
		}

		if(count($qtdds['value']) < 1){
			return 'Nenhum Dado Informado.&ApDanger';
		}

		foreach($data as $dat){
			list($type, $info) = explode('&&', $dat);
			if($type == 'qtd' || $type == 'date' ){
				list($estagioId, $moreInfo) = explode('&', $info);
				list($conjuntoId, $value) = explode('=', $moreInfo);
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
					$update->update($upEstagio);	
					}
					
				}elseif($type == 'date'){

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
			return 'Apontamento Executado com Sucesso.&ApSuccess';
		}
	}

	
}