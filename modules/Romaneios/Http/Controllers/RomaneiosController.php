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
	
}