<?php namespace Modules\Apontador\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Obra as obr;
use App\Etapa as etap;
use App\Subetapa as sub;
use App\Importacao as imp;
use App\Handle as handle;
use App\Estagio as est;

class ApontadorController extends Controller {
	
	public function index()
	{
        $obras = obr::all(); 
        if(\Session::get('history')){
        	$conjuntos = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('etapa_id',\Session::get('history'))->where('FLG_REC',3)->groupBy('MAR_PEZ')->get();
        	$estagios = est::orderBy('ordem','asc')->get();
            $etapa = etap::find(\Session::get('history'));
            $etapas = etap::where('obra_id',$etapa->obra_id)->get();
            $history = true;
            return view('apontador::index',compact('obras', 'etapas', 'etapa', 'history','conjuntos','estagios'));
        }
		return view('apontador::index', compact('obras'));
	}

	public function setHistory(Request $request){
		$dados = $request->all();
		\Session::flash('history', $dados['id']);
		return route('apontador');
	}
	
}