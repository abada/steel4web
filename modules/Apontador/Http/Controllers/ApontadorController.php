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

					if(!empty($crono->first()->data_real)){
						$ended = true;

						if(!empty($estg->first()->lote_id)){
							foreach($estg as $ets){
								if($ets->estagio_id <= $estagio->id){
									$ended = false;
								}
							}
						}
							
					}
					if($ended == true){
						echo " <td><input min='0' max='0' style='line-height:15px' type='number' disabled value='0' style='line-height:15px'></td>
	                    <td><input style='line-height:15px' type='text' disabled style='line-height:15px' value='".date('d/m/Y',strtotime($crono->first()->data_real))."'></td> ";
					}else{
						$disable = ($qtd < 1) ? ' disabled ' : ''; 
						echo " <td><input type='number' ".$disable." onkeydown='return false' class='row-qtd' name='qtd&&".$estagio->id."&".$conjunto->id."' value='' min='0' max='".$qtd."' placeholder='".$qtd."' style='line-height:15px'></td>
	                    <td><input type='date' class='row-date' ".$disable." name='date&&".$estagio->id."&".$conjunto->id."' style='line-height:15px' value=''></td> ";
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
		\Session::flash('history', $dados);
		return route('apontador');
	}

	public function apontar(Request $request){
		$dados = $request->all();
		$dados = explode('&xXx&', $dados['dados']);
		$data = array();
		foreach($dados as $newDados){
			$haveStuff = substr($newDados, -1);
			if($haveStuff != '='){
				$data[] = $newDados;
			}
		}
		
		dd($data);
	}

	
}