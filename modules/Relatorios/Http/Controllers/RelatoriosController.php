<?php namespace Modules\Relatorios\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Obra as obr;
use App\Lote as lote;
use App\Handle as handle;
use App\Cronograma as crono;
use PDF;

class RelatoriosController extends Controller {
	
	public function index(){
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
			$response['data'] = $this->getConjuntosLote($p);
		}
		return json_encode($response);
	}

	private function getConjuntosLote($params){
		
		if($params > 0){
			$lote = lote::find($params);
			$conjuntos = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('FLG_REC',3)->where('lote_id',$lote->id)->groupBy('MAR_PEZ')->get();
			
			foreach($conjuntos as $conj){
				$pesos = handle::selectRaw('sum(PUN_LIS) as peso')->where('FLG_REC',4)->where('importacao_id',$conj->importacao_id)->where('MAR_PEZ',$conj->MAR_PEZ)->first();
				$data[] = array(
						'marcas' 	=> $conj->MAR_PEZ,
						'qtd'    	=> $conj->qtd,
						'peso_unid' => $pesos->peso,
						'peso_tot'  => $pesos->peso * $conj->qtd
				);
			}
		}else{
			$data = array(''=>'');
		}
		
		$response =  $data;
		return $response;
	}

	public function getEstagios($id){
		$data = array();
		$cronos = crono::where('lote_id',$id)->orderBy('estagio_id', 'asc')->get();
		if($id > 0){
			$x = 0;
			foreach($cronos as $crono){
				$data[$x] = array(
						'estagio' => $crono->estagio->descricao,
						'prev'    => date('d/m/Y', strtotime($crono->data_prev)),
				);
				$x++;
		}	
		}else{
			$data = array(''=>'');
		}
		$response['data'] =  $data;
		return json_encode($response);
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

	public function getPdfLote($params){
		$cronos = crono::where('lote_id',$params)->orderBy('estagio_id', 'asc')->get();
		$conjuntos = $this->getConjuntosLote($params);
		$parameter = array();
		$lote = lote::find($params);
		$parameter['lote'] = $lote;
		$parameter['conjuntos'] = $conjuntos;
		$parameter['cronos'] = $cronos;
        $parameter['title'] = $lote->descricao.' - '.date('d/m/Y');
        $title = $lote->descricao.'-'.date('d-m-Y').'.pdf';

        $pdf = PDF::loadView('relatorios::pdfs.lote', $parameter);
        return $pdf->stream($title);
	}

	public function teste(){
		$parameter = array();
		$parameter['obras'] = obr::all();
        $parameter['title'] = 'Obras '.access()->user()->locatario->fantasia.' - '.date('d/m/Y');
        $title = 'obras-'.strtolower(access()->user()->locatario->fantasia).'-'.date('d-m-Y').'.pdf';
 
        $pdf = PDF::loadView('relatorios::pdfs.obras', $parameter);
        return $pdf->download($title);
	}
	
}