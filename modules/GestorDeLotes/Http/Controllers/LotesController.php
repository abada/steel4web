<?php namespace Modules\Gestordelotes\Http\Controllers;
use App\CjtoFabr;
use App\Cronograma;
use App\Handle;
use App\Lote;
use App\Obra;
use Illuminate\Http\Request;
use JavaScript;
use Pingpong\Modules\Routing\Controller;

class LotesController extends Controller {

	public function index(Request $request) {

		$lotes = Lote::all();
		$obras = Obra::all()->lists('nome', 'id');

		if ($request->old('obra_id')) {
			$etapas = Obra::find($request->old('obra_id'))->etapas->lists('codigo', 'id');
		} else {
			$etapas = array();
		}

		$estagios = access()->user()->locatario->estagios->where('tipo', 2)->sortBy('ordem');

		$columns = array();
		foreach ($estagios as $estagio) {
			$columns[] = ['data' => 'ESTAGIO_' . $estagio->id];
		}

		JavaScript::put([
			'urlbase' => env('APP_URL') . env('APP_URLPREFIX'),
			'obra_id' => $request->old('obra_id'),
			'etapa_id' => $request->old('etapa_id'),
			'etapas' => $etapas,
			'selected' => $request->old('handles_ids'),
			'columns' => $columns,
		]);

		return view('gestordelotes::lotes.index', compact('obras', 'lotes', 'etapas', 'estagios'));

	}

	public function getHandles(Request $request) {
		$data = $request->all();

		if (null == @$data['obra']) {return json_encode(['' => '']);}
		if (null == @$data['etapa']) {return json_encode(['' => '']);}
		if (null == @$data['subetapa']) {return json_encode(['' => '']);}

		$obra_id = $data['obra'];
		$etapa_id = $data['etapa'];
		$subetapa_id = $data['subetapa'];

		// GET LOTES
		$lotes = Lote::where('obra_id', $obra_id)
			->where('etapa_id', $etapa_id)
			->where('subetapa_id', $subetapa_id)
			->get();

		$handlesOfLote = array();
		foreach ($lotes as $lote) {
			$handlesOfLote[] = Handle::where('lote_id', $lote->id)->selectRaw('*, SUM(QTA_PEZ) as QTA_PEZ')->groupBy('MAR_PEZ')->get();
		}

		// CONTINUAR AQUI...

		$response = array();
		$response['data'] = array();

		$estagios = access()->user()->locatario->estagios->where('tipo', 2)->sortBy('ordem');

		foreach ($handlesOfLote as $handleGroup) {

			foreach ($handleGroup as $handle) {

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
					'DES_PEZ' => getIcon($handle->DES_PEZ),
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
					'estagio' => date('d/m/Y', strtotime($handle->importacao->created_at)), //$handle->estagio->descricao,
					'GROUP' => $handle->GROUP,
					'etapa_id' => $handle->etapa_id,
					'CATE' => $handle->CATE,
					'importacao_id' => 'IMP-0' . $handle->importacao_id,

					// 'status' => null,
				);
				foreach ($estagios as $estagio) {

					if ($handle->lote_id) {
						$cjtofab = CjtoFabr::where('lote_id', $handle->lote_id)->first();
						$cronograma = Cronograma::where('estagio_id', $estagio->id)->where('cjtofab_id', @$cjtofab->id)->first();
					}
					if (null !== @$cronograma && null !== $cronograma->data_prev) {
						$data_prev = ['ESTAGIO_' . $estagio->id => date('d/m/Y', strtotime($cronograma->data_prev))];
					} else {
						$data_prev = ['ESTAGIO_' . $estagio->id => null];
					}

					$responsedata = array_merge($responsedata, $data_prev);
				}

				$response['data'][] = $responsedata;
			}

		}

		$response['current'] = $request->input('current', 1);
		$response['rowCount'] = $request->input('rowCount', 10);
		$response['total'] = count($handlesOfLote);

		return json_encode($response);
	}

	public function removerconjuntos(Request $request) {

		$data = $request->all();

		// Salva o Cronograma do Conjunto
		$data['obra_id'] = @$data['obra_id'];
		$data['etapa_id'] = @$data['etapa_id'];
		$conjuntos = array();

		foreach (@$data['handles_ids'] as $conjunto => $qtd) {

			$handles_conjunto = Handle::where('MAR_PEZ', $conjunto)->whereNotNull('lote_id')->where('FLG_REC', 3)->orderBy('X', 'desc')->orderBy('Y', 'desc')->orderBy('Z', 'desc')->take($qtd)->get();

			foreach ($handles_conjunto as $handle) {

				//Remove lote vazio
				if ($handle->lote->handles->count() == 1) {
					Lote::destroy($handle->lote->id);
				} else {
					// Atualiza HANDLE [lote]
					$handle->lote_id = null;
					$handle->save();
				}

				$conjuntos[] = $handle->id;

			}
		}

		return json_encode($conjuntos);
	}

	/**
	 * [removerlote description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function removerlote(Request $request) {

		$data = $request->all();

		$destroyed = array();

		foreach (@$data['lotes'] as $lote) {

			if (Lote::destroy($lote)) {
				$destroyed[] = $lote;
			}

		}

		return json_encode($destroyed);
	}

	/**
	 * [associar description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function associar(Request $request, $id = null) {

		$data = $request->all();
		$data['id'] = $id;

		$conjuntos = array();

		foreach (@$data['handles_ids'] as $conjunto => $qtd) {

			$handles_conjunto = Handle::where('MAR_PEZ', $conjunto)->whereNotNull('lote_id')->where('FLG_REC', 3)->orderBy('X', 'desc')->orderBy('Y', 'desc')->orderBy('Z', 'desc')->take($qtd)->get();

			foreach ($handles_conjunto as $handle) {

				//Remove lotes vazios
				if ($handle->lote->handles->count() == 1) {
					Lote::destroy($handle->lote->id);
				} else {
					// Atualiza HANDLE [lote]
					$handle->lote_id = $id;
					$handle->save();
				}

				$conjuntos[] = $handle->id;
			}
		}

		return json_encode($conjuntos);
	}

}