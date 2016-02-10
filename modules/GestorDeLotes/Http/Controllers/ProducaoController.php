<?php namespace Modules\Gestordelotes\Http\Controllers;

use App\Lote;
use App\Obra;
use Illuminate\Http\Request;
use JavaScript;
use Pingpong\Modules\Routing\Controller;

class ProducaoController extends Controller {

	/**
	 * [index description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
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

		return view('gestordelotes::producao.index', compact('obras', 'lotes', 'etapas', 'estagios'));
	}

	/**
	 * [create description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function create(Request $request) {
		$data = $request->all();
		return $data;
	}

	/**
	 * [store description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function store(Request $request) {
		$data = $request->all();

		// pega os lotes a enviar pra produção
		// Altera na handles para o próximo estágio

		// Tabela LOTES.producao = true
		// CRONOS.data_real = no primeiro estágio

		$done = 0;
		foreach (@$data['lotes'] as $lote_id) {

			$lote = Lote::find($lote_id);

			if ($lote) {

				$estagiosdolote = $lote->estagios();
				$estagiosdolote_ids = array();
				foreach ($estagiosdolote as $estagio) {
					$estagiosdolote_ids[] = $estagio->id;
				}

				// Estagio atual
				$estagioatual = $lote->handles->first()->estagio_id;
				$key = array_search($estagioatual, $estagiosdolote_ids);

				// Altera na HANDLES para o próximo estágio
				if (!$key) {
					// 	$lote->handles()->update(array("estagio_id" => $key++)); //altera
					// } else {

					foreach ($lote->cronogramas as $crono) {

						if ($crono->estagio_id == $estagiosdolote_ids[$key]) {
							$crono->data_real = date('Y-m-d');
							$crono->save();
						}
					}
					$lote->handles()->update(array("estagio_id" => reset($estagiosdolote_ids)));
				}

				// Marca lote como enviado para produção
				$lote->producao = true;
				$lote->save();

				$done++;
			}

		}
		return $done;
	}

	/**
	 * [show description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function show(Request $request) {
		$data = $request->all();
		return $data;
	}

	/**
	 * [destroy description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function destroy(Request $request) {
		$data = $request->all();
		return $data;
	}

}