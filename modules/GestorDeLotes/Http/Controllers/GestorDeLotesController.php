<?php namespace Modules\Gestordelotes\Http\Controllers;

use App\Lote;
use App\Obra;
use Illuminate\Http\Request;
use JavaScript;
use Pingpong\Modules\Routing\Controller;

class GestorDeLotesController extends Controller {

	public function index(Request $request) {
		$lotes = Lote::all();
		$obras = Obra::all()->lists('nome', 'id');

		// if ($request->ajax()) {
		// 	dd($request);
		// } else {

		if ($request->old('obra_id')) {
			$etapas = Obra::find($request->old('obra_id'))->etapas->lists('codigo', 'id');
		} else {
			$etapas = array();
		}

		$columns[] = ['data' => NULL, 'defaultContent' => '', 'className' => 'select-checkbox', 'orderable' => true];
		$columns[] = ['data' => 'importacao_id'];
		$columns[] = ['data' => 'lote'];
		$columns[] = ['data' => 'MAR_PEZ'];
		$columns[] = ['data' => 'FLG_DWG'];
		$columns[] = ['data' => 'QTA_PEZ'];
		$columns[] = ['data' => 'DES_PEZ'];
		$columns[] = ['data' => 'TRA_PEZ'];
		$columns[] = ['data' => 'estagio'];

		$estagios = access()->user()->locatario->estagios->where('tipoestagio_id', 2)->sortBy('ordem');

		foreach ($estagios as $estagio) {
			$columns[] = ['data' => 'ESTAGIO_' . $estagio->id];
		}

		JavaScript::put([
			'urlbase' => url('/'),
			'obra_id' => $request->old('obra_id'),
			'etapa_id' => $request->old('etapa_id'),
			'etapas' => $etapas,
			'selected' => $request->old('handles_ids'),
			'columns' => $columns,
		]);

		return view('gestordelotes::index', compact('obras', 'lotes', 'etapas', 'estagios'));
		// }
	}

	public function lotes(Request $request) {
		dd($request->all());
	}

}