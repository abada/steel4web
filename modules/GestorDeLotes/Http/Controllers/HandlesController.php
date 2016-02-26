<?php namespace Modules\Gestordelotes\Http\Controllers;

use App\CronogramaPrevisto;
use App\Estagio;
use App\Handle;
use DB;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;

class HandlesController extends Controller {

	public function index(Request $request) {

		$data = $request->all();

		if (null == @$data['obra']) {return json_encode(['' => '']);}
		if (null == @$data['etapa']) {return json_encode(['' => '']);}
		if (null == @$data['subetapa']) {return json_encode(['' => '']);}

		$obra_id = $data['obra'];
		$etapa_id = $data['etapa'];
		$subetapa_id = $data['subetapa'];

		$flg_rec = $request->input('flg_rec', 3);

		$orderBy = $request->input('sort', ['id' => 'asc']);

		$handle = new Handle;

		$handles = $handle->where('obra_id', $obra_id)
			->where('etapa_id', $etapa_id)
			->where('subetapa_id', $subetapa_id);

		if (isset($data['haslote'])) {
			$handles = $handles->where('lote_id', '>', 0);
		} else {
			$handles = $handles->where('lote_id', '=', null);
		}

		if ($request->input('ungrouped')) {
			$handles = $handles->get();
		} else {
			if ($flg_rec == 3) {
				// Grouped ...
				$handles = $handles->where('FLG_REC', 3);
				$handles = $handles->groupBy('MAR_PEZ');
				$handles = $handles->select($handle->getTable() . '.*', DB::raw('SUM(QTA_PEZ) as QTA_PEZ'));
				$handles = $handles->get();
			} else {
				// Grouped ...
				$handles = $handles->where('FLG_REC', 4);
				$handles = $handles->groupBy('POS_PEZ');
				$handles = $handles->select($handle->getTable() . '.*', DB::raw('SUM(QTA_PEZ) as QTA_PEZ'));
				$handles = $handles->get();
			}
		}

		$response = array();
		$response['data'] = array();
		$estagios = Estagio::where('tipo', '>', 1)->where('tipo', '<', 11)->orderBy('ordem')->get();

		foreach ($handles as $handle) {

			$responsedata = array(
				'id' => $handle->id,
				'PROJETO' => $handle->PROJETO,
				'HANDLE' => $handle->HANDLE,
				'FLG_REC' => $handle->FLG_REC,
				'NUM_COM' => $handle->NUM_COM,
				'DES_COM' => $handle->DES_COM,
				'LOT_COM' => $handle->LOT_COM,
				'DLO_COM' => $handle->DLO_COM,
				'CLI_COM' => $handle->CLI_COM,
				'IND_COM' => $handle->IND_COM,
				'DT1_COM' => $handle->DT1_COM,
				'DT2_COM' => $handle->DT2_COM,
				'NUM_DIS' => $handle->NUM_DIS,
				'DES_DIS' => $handle->DES_DIS,
				'NOM_DIS' => $handle->NOM_DIS,
				'REV_DIS' => $handle->REV_DIS,
				'DAT_DIS' => $handle->DAT_DIS,
				'TRA_PEZ' => $handle->TRA_PEZ,
				'SBA_PEZ' => $handle->SBA_PEZ,
				'DES_SBA' => $handle->DES_SBA,
				'TIP_PEZ' => $handle->TIP_PEZ,
				'MAR_PEZ' => $handle->MAR_PEZ,
				'MBU_PEZ' => $handle->MBU_PEZ,
				'DES_PEZ' => $handle->DES_PEZ,
				'ICON' => getIcon($handle->DES_PEZ),
				'POS_PEZ' => $handle->POS_PEZ,
				'NOT_PEZ' => $handle->NOT_PEZ,
				'ING_PEZ' => $handle->ING_PEZ,
				'MAX_LEN' => $handle->MAX_LEN,
				'QTA_PEZ' => $handle->QTA_PEZ,
				'QT1_PEZ' => $handle->QT1_PEZ,
				'MCL_PEZ' => $handle->MCL_PEZ,
				'COD_PEZ' => $handle->COD_PEZ,
				'COS_PEZ' => $handle->COS_PEZ,
				'NOM_PRO' => (null !== $handle->NOM_PRO) ? $handle->NOM_PRO : '',
				'LUN_PRO' => $handle->LUN_PRO,
				'LAR_PRO' => $handle->LAR_PRO,
				'SPE_PRO' => number_format($handle->SPE_PRO, 2, '.', ''),
				'MAT_PRO' => $handle->MAT_PRO,
				'TIP_BUL' => $handle->TIP_BUL,
				'DIA_BUL' => $handle->DIA_BUL,
				'LUN_BUL' => $handle->LUN_BUL,
				'PRB_BUL' => $handle->PRB_BUL,
				'PUN_LIS' => $handle->PUN_LIS,
				'SUN_LIS' => $handle->SUN_LIS,
				'PRE_LIS' => $handle->PRE_LIS,
				'FLG_DWG' => $handle->FLG_DWG,
				'obra_id' => $handle->obra_id,
				'lote_id' => $handle->lote_id,
				'lote' => ($handle->lote_id) ? $handle->lote->descricao : '',
				'estagio' => date('d/m/Y', strtotime($handle->importacao->created_at)), //$handle->estagio->descricao,
				'GROUP' => $handle->GROUP,
				'etapa_id' => $handle->etapa_id,
				'CATE' => $handle->CATE,
				'importacao_id' => 'IMP-' . str_pad($handle->importacao->importacaoNr, 3, "0", STR_PAD_LEFT),
			);
			foreach ($estagios as $estagio) {

				if ($handle->lote_id) {
					$cronograma = CronogramaPrevisto::where('estagio_id', $estagio->id)->where('lote_id', $handle->lote_id)->first();
				}
				if (null !== @$cronograma) {
					$data_prev = ['ESTAGIO_' . $estagio->id => $cronograma->data];
				} else {
					$data_prev = ['ESTAGIO_' . $estagio->id => null];

				}

				$responsedata = array_merge($responsedata, $data_prev);
			}

			$response['data'][] = $responsedata;
		}

		$response['current'] = $request->input('current', 1);
		$response['rowCount'] = $request->input('rowCount', 10);
		$response['total'] = $handles->count();

		return json_encode($response);
	}

}