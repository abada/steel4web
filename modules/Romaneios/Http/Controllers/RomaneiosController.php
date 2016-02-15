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

class RomaneiosController extends Controller {
	
	public function index()
	{
		$obras = obr::all();
		if(\Session::get('history')){
        	$ids = (\Session::get('history'));
        	if($ids['eID'] == 0)
        		$conjuntos = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('obra_id',$ids['oID'])->where('FLG_REC',3)->groupBy('MAR_PEZ')->groupBy('lote_id')->get();
        	elseif($ids['sID'] == 0)
        		$conjuntos = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('etapa_id',$ids['eID'])->where('FLG_REC',3)->groupBy('MAR_PEZ')->groupBy('lote_id')->get();
        	elseif($ids['iID'] == 0)
        		$conjuntos = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('subetapa_id',$ids['sID'])->where('FLG_REC',3)->groupBy('MAR_PEZ')->groupBy('lote_id')->get();
        	else
        		$conjuntos = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('subetapa_id',$ids['sID'])->where('FLG_REC',3)->where('importacao_id', $ids['iID'])->groupBy('MAR_PEZ')->groupBy('lote_id')->get();

        	$estagios = est::orderBy('ordem','asc')->get();
        	$obraID = $ids['oID'];
        	$etapas = etap::where('obra_id',$ids['oID'])->get();
        	if($ids['eID'] != 0){
				$etapa = etap::find($ids['eID']);
           	    $subetapas = sub::where('etapa_id', $ids['eID'])->get();
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

			if($ids['iID'] != 0){
				$thisImp = imp::find($ids['iID']);
            	
			}else{
				$thisImp = null;
				
			}
            
            
            
            $history = true;
            return view('romaneios::index',compact('obras','obraID', 'etapas', 'etapa', 'history','conjuntos','estagios', 'subetapas', 'thisSubetapa', 'importacoes', 'thisImp'));
        }
		return view('romaneios::index', compact('obras'));
	}

	public function setHistory(Request $request){
		$dados = $request->all();
		\Session::flash('history', $dados);
		return route('romaneios');
	}

	public function criar(){
		$obras = obr::all();
		return view('romaneios::criar', compact('obras'));
	}

	public function getConjuntos($params){
		if($params == "0X0X0X0"){
			$data = array('aaData' => [
				'' => ''
				]
			);
		}else{
			$data = array();
			$dados = explode('X', $params);
			if(empty($dados[2])){
				$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->get();
			}elseif(empty($dados[3])){
				$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->get();
			}else{
				$handles = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('obra_id',$dados[0])->where('etapa_id',$dados[1])->where('subetapa_id',$dados[2])->where('importacao_id',$dados[3])->where('FLG_REC', 3)->groupBy('MAR_PEZ')->get();
			}
			foreach($handles as $handle){
				$lote = !empty($handle->lote->descricao) ? $handle->lote->descricao : '-';
				$data[] = array(
				'select-checkbox' => '',
				'qtd' => "<input type='number' onkeydown='return false' class='row-qtd input-sm form-control' name='qtd&&".$handle->id."&".$handle->id."' value='' min='0' max='".$handle->qtd."' placeholder='".$handle->qtd."'>",
				'lote' => $lote,
				'conjunto' => $handle->MAR_PEZ,
				'descricao' => "<img class='tooltipo'  data-placement='right' data-toggle='tooltip' data-html='true' title='".$handle->DES_PEZ."' src='".asset('img/icons/'.getIcon($handle->DES_PEZ))."''>",
				'tratamento' => $handle->TRA_PEZ,
				'total' => $handle->qtd,
				'carregado' => $handle->qtd,
				'saldo' => $handle->qtd,
				'cargo' => 'carg',
				'romaneio' => 'rom'
				);
		}
		}
		$total = empty($handles) ? 0 : $handles->count();
		$response['data'] =  $data;
		$response['current'] = 1;
		$response['rowCount'] = 11;
		$response['total'] = $total;

			
		return json_encode($response);
	}

	public function gravar(Request $request){
        $dados = $request->all();
        $romaneios = explode('&', $dados['romaneio']);
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
        dd($Romaneio);
	}
	
}