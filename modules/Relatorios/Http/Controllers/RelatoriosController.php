<?php namespace Modules\Relatorios\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Obra as obr;
use App\Lote as lote;
use PDF;

class RelatoriosController extends Controller {
	
	public function index()
	{
		return view('relatorios::index');
	}

	public function obras(){
		 $obras = obr::has('importacoes')->where('status',1)->get(); 
		return view('relatorios::obras', compact('obras'));
	}

	public function lotes(){
		 $obras = obr::has('lotes')->where('status',1)->get(); 
		return view('relatorios::lotes', compact('obras'));
	}

	public function getConjuntos($params){
		list($type, $p) = explode('XxX', $params);
		if($type == 'lotes'){
			$response = $this->getConjuntosLote($p);
		}
		return json_encode($response);
	}

	private function getConjuntosLote($params){
		$data = array(''=>'');
		if($params > 0){
			$lote = lote::find($params);
			dd($lote);
		}
		
		$response['data'] =  $data;
		return $response;
	}

	private function getConjuntosObra($id){
		if($id == 0){
			$data = array(''=>'');
		}else{
			$obra = obr::find($id);
			$data = array();
			$data[] = array(
				'nome' => $obra->nome,
				'cliente' => $obra->cliente->razao,
				'descricao' => $obra->descricao,
			);
		}
		$response['data'] =  $data;


		return json_encode($response);
	}

	public function teste(){
		$parameter = array();
		$parameter['obras'] = obr::all();
        $parameter['title'] = 'Obras '.access()->user()->locatario->fantasia.' - '.date('d/m/Y');
        $title = 'obras-'.strtolower(access()->user()->locatario->fantasia).'-'.date('d-m-Y').'.pdf';
 
        $pdf = PDF::loadView('relatorios::pdfs.obras', $parameter);
        return $pdf->stream($title);
	}
	
}