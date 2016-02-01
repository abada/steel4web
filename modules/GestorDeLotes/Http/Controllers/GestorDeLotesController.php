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

		if ($request->ajax()) {
			dd($request);
		} else {

			if ($request->old('obra_id')) {
				$etapas = Obra::find($request->old('obra_id'))->etapas->lists('codigo', 'id');
			} else {
				$etapas = array();
			}

			JavaScript::put([
				'urlbase' => env("APP_URL") . env("APP_URLPREFIX", '/public'),
				'obra_id' => $request->old('obra_id'),
				'etapa_id' => $request->old('etapa_id'),
				'etapas' => $etapas,
				'selected' => $request->old('handles_ids'),
			]);

			return view('gestordelotes::index', compact('obras', 'lotes', 'etapas'));
		}
	}

}