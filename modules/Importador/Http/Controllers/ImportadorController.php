<?php namespace Modules\Importador\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Obra as obr;
use App\Etapa as etap;
use App\Subetapa as sub;

class ImportadorController extends Controller {
	
	public function index()
	{
		$obras = obr::all(); 
		return view('importador::index',compact('obras'));
	}

	public function getEtapas(Request $request){
		$dados = $request->all();
        $data = $dados['id'];
        $that = etap::where('obra_id', $data)->get();
        $all = '';
        $x = 0;
        foreach($that as $etapa){
            $all .= $etapa->id.'&'.$etapa->codigo;
            $x++;
            if($x < count($that)){
                $all .= '&x&';
            }

        }
            return $all;
        die(); 
    }

    public function getSubetapas(Request $request){
		$dados = $request->all();
        $data = $dados['id'];
        $that = sub::where('etapa_id', $data)->get();
        $all = '';
        $x = 0;
        foreach($that as $subetapa){
            $all .= $subetapa->id.'&'.$subetapa->cod;
            $x++;
            if($x < count($that)){
                $all .= '&x&';
            }

        }
            return $all;
        die(); 
    }

    public function toImport(Request $request){
    	$dados = $request->all();
    	$data = $dados['id'];
    	$subetapa = sub::find($data);
    	/*$send = array(
    		'subetapa_id'  =>  
    	); */
    }
	
}