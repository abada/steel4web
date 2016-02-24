<?php namespace Modules\Relatorios\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Obra as obr;
use App\Lote as lote;
use App\Handle as handle;
use App\Cronograma as crono;
use PDF;
use Illuminate\Http\Request;
use Session;

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

	private function getConjuntosLote($params,$toSend = null){
		
		if($params > 0){
			$lote = lote::find($params);
			$conjuntos = handle::selectRaw('*, sum(QTA_PEZ) as qtd')->where('FLG_REC',3)->where('lote_id',$lote->id)->groupBy('MAR_PEZ')->get();
			$pesoTotal = 0;
			foreach($conjuntos as $conj){
				$pesos = handle::selectRaw('sum(PUN_LIS) as peso')->where('FLG_REC',4)->where('importacao_id',$conj->importacao_id)->where('MAR_PEZ',$conj->MAR_PEZ)->first();
				$pesoTot = ($pesos->peso * $conj->qtd);

				if($toSend != null){
					$data[] = array(
						'marcas' 	=> $conj->MAR_PEZ,
						'qtd'    	=> $conj->qtd,
						'peso_unid' => $pesos->peso,
						'peso_tot'  => $pesoTot,
				);

				}else{
					$data[] = array(
					'marcas' 	=> $conj->MAR_PEZ,
					'qtd'    	=> $conj->qtd,
					'peso_unid' => number_format($pesos->peso, 2, ',','.'),
					'peso_tot'  => number_format($pesoTot, 2, ',','.')
				);
				}
				$pesoTotal = $pesoTot + $pesoTotal;

				
			}
			if($toSend != null){
				$data['pesoTotal'] = $pesoTotal;
				return $data;
			}


		}else{
			$data = array(''=>'');
		}
		
		$response =  $data;
		return $response;
	}

	public function getEstagios($id){
		$data = array();
		$handles = $this->getConjuntosLote($id, true);

		$cronos = crono::where('lote_id',$id)->orderBy('estagio_id', 'asc')->get();
		if(!empty($handles['pesoTotal'])){
			$pesoT =  $handles['pesoTotal'];
			unset($handles['pesoTotal']);
			$x = 0;

			foreach($cronos as $crono){
				$pesoE = 0;
				$count = 0;
				foreach($crono->estagio->handles as $hand){
					if($hand->lote_id == $crono->lote_id){
						foreach($handles as $hande){
							if($hande['marcas'] == $hand->MAR_PEZ){
								$pesoU = $hande['peso_unid'];
							}
						}
						$pesoE = $pesoE + $pesoU;
					}
				}

				$porc = $pesoE/$pesoT * 100;
				
				$data[$x] = array(
						'estagio' => $crono->estagio->descricao,
						'prev'    => date('d/m/Y', strtotime($crono->data_prev)),
						'peso'    => number_format($pesoE, 2, ',','.'),
						'porc'    => round($porc).' %'
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

	public function lotePeso($id){
		$ses = $this->getConjuntosLote($id, true);
		$peso = number_format($ses['pesoTotal'], 2, ',','.');
		return $peso;
	}

	public function getPdfLote($params){
		$cronos = crono::where('lote_id',$params)->orderBy('estagio_id', 'asc')->get();
		$handles = $this->getConjuntosLote($params, true);
		foreach($cronos as $crono){
				$pesoE = 0;
				$count = 0;
				foreach($crono->estagio->handles as $hand){
					if($hand->lote_id == $crono->lote_id){
						foreach($handles as $hande){
							if($hande['marcas'] == $hand->MAR_PEZ){
								$pesoU = $hande['peso_unid'];
							}
						}
						$pesoE = $pesoE + $pesoU;
					}
				}

				$porc = $pesoE/$handles['pesoTotal'] * 100;
				
				$data[] = array(
						'estagio' => $crono->estagio->descricao,
						'prev'    => date('d/m/Y', strtotime($crono->data_prev)),
						'peso'    => number_format($pesoE, 2, ',','.'),
						'porc'    => round($porc).' %'
				);

		}
		$parameter = array();
		$lote = lote::find($params);
		$parameter['lote'] = $lote;
		$parameter['pesoTotal'] = $handles['pesoTotal'];
		unset($handles['pesoTotal']);
		$parameter['conjuntos'] = $handles;
		$parameter['estagios'] = $data;
        $parameter['title'] = $lote->descricao.' - '.date('d/m/Y');
        $title = str_slug($lote->descricao.'-'.date('d-m-Y')).'.pdf';

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