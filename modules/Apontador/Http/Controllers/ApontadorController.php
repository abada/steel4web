<?php namespace Modules\Apontador\Http\Controllers;


use Illuminate\Http\Request;
use App\Obra as obr;
use App\Etapa as etap;
use App\Subetapa as sub;
use App\Importacao as imp;
use App\Handle as handle;
use App\Estagio as est;
use App\Lote as lote;
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

        	$estagios = est::orderBy('ordem','asc')->get();
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

	public function setHistory(Request $request){
		$dados = $request->all();
		\Session::flash('history', $dados);
		return route('apontador');
	}
	
}