<?php namespace Modules\Gestordelotes\Http\Controllers;

use App\Cronograma;
use App\Handle;
use DB;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;

class HandlesController extends Controller {

	public function index(Request $request) {

		$data = $request->all();
		if (null == @$data['obra']) {return "Informe a obra";}
		if (null == @$data['etapa']) {return "Informe a etapa";}
		if (null == @$data['subetapa']) {return "Informe a subetapa";}
		$obra_id = $data['obra'];
		$etapa_id = $data['etapa'];
		$subetapa_id = $data['subetapa'];

		$flg_rec = $request->input('flg_rec', 3);

		$orderBy = $request->input('sort', ['id' => 'asc']);

		$handle = new Handle;
		$cronograma = new Cronograma;

		$handles = $handle->where('obra_id', $obra_id)
			->where('etapa_id', $etapa_id)
			->where('subetapa_id', $subetapa_id)
			->where('FLG_REC', $flg_rec);

		// $handles = $handle->join($cronograma->getTable() . ' as cronograma', 'cronograma.fkpeca', '=', $handle->getTable() . '.id')
		// 	->where($handle->getTable() . '.obra', $obra_id)
		// 	->where($handle->getTable() . '.fketapa', $etapa_id)
		// 	->where($handle->getTable() . '.FLG_REC', $flg_rec)
		// 	->orderBy('cronograma.' . current(array_keys($orderBy)), current($orderBy))
		// 	->select($handle->getTable() . '.*') // just to avoid fetching anything from joined table
		// 	->with('lote'); // if you need options data anyway

		// if ($request->input('grouped')) {

		if ($flg_rec == 3) {
			$handles = $handles->groupBy('MAR_PEZ')
				->select($handle->getTable() . '.*', DB::raw('SUM(QTA_PEZ) as QTA_PEZ'))
				->get();
		} else {
			$handles = $handles->groupBy('POS_PEZ')
				->select($handle->getTable() . '.*', DB::raw('SUM(QTA_PEZ) as QTA_PEZ'))
				->get();
		}

		// } else {
		// 	$handles = $handles->get();
		// }

		$estagios = access()->user()->locatario->estagios->sortBy('ordem');

		// if ($request->ajax()) {

		$response = array();
		$response['data'] = array();

		foreach ($handles as $handle) {

			// dd($handle->estagio);

			$response['data'][] = [
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
				'POS_PEZ' => $handle->POS_PEZ,
				'NOT_PEZ' => $handle->NOT_PEZ,
				'ING_PEZ' => $handle->ING_PEZ,
				'MAX_LEN' => $handle->MAX_LEN,
				'QTA_PEZ' => $handle->QTA_PEZ,
				'QT1_PEZ' => $handle->QT1_PEZ,
				'MCL_PEZ' => $handle->MCL_PEZ,
				'COD_PEZ' => $handle->COD_PEZ,
				'COS_PEZ' => $handle->COS_PEZ,
				'NOM_PRO' => $handle->NOM_PRO,
				'LUN_PRO' => $handle->LUN_PRO,
				'LAR_PRO' => $handle->LAR_PRO,
				'SPE_PRO' => $handle->SPE_PRO,
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
				'estagio' => $handle->estagio->descricao,
				'GROUP' => $handle->GROUP,
				'etapa_id' => $handle->etapa_id,
				'CATE' => $handle->CATE,
				'importacao_id' => $handle->importacao_id,
				'medicao_id' => $handle->medicao_id,

				// 'dataprojeto' => date('d/m/Y', strtotime($handle->importacao->data)),
				// 'dataprev_pcp' => ($handle->conjuntoCronograma->dataprev_pcp) ? date('d/m/Y', strtotime($handle->conjuntoCronograma->dataprev_pcp)) : null,
				// 'dataprev_preparacao' => ($handle->conjuntoCronograma->dataprev_preparacao) ? date('d/m/Y', strtotime($handle->conjuntoCronograma->dataprev_preparacao)) : null,
				// 'dataprev_gabarito' => ($handle->conjuntoCronograma->dataprev_gabarito) ? date('d/m/Y', strtotime($handle->conjuntoCronograma->dataprev_gabarito)) : null,
				// 'dataprev_solda' => ($handle->conjuntoCronograma->dataprev_solda) ? date('d/m/Y', strtotime($handle->conjuntoCronograma->dataprev_solda)) : null,
				// 'dataprev_pintura' => ($handle->conjuntoCronograma->dataprev_pintura) ? date('d/m/Y', strtotime($handle->conjuntoCronograma->dataprev_pintura)) : null,
				// 'dataprev_expedicao' => ($handle->conjuntoCronograma->dataprev_expedicao) ? date('d/m/Y', strtotime($handle->conjuntoCronograma->dataprev_expedicao)) : null,
				// 'dataprev_montagem' => ($handle->conjuntoCronograma->dataprev_montagem) ? date('d/m/Y', strtotime($handle->conjuntoCronograma->dataprev_montagem)) : null,
				// 'dataprev_entrega' => ($handle->conjuntoCronograma->dataprev_entrega) ? date('d/m/Y', strtotime($handle->conjuntoCronograma->dataprev_entrega)) : null,

				// 'status' => null,
			];
		}

		$response['current'] = $request->input('current', 1);
		$response['rowCount'] = $request->input('rowCount', 10);
		$response['total'] = $handles->count();

		return json_encode($response);

		// } else {
		// 	dd($handles);
		// }
	}

}