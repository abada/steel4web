<?php namespace Modules\Gestordelotes\Http\Controllers;

use App\Estagio;
use App\Lote;
use App\Obra;
use Illuminate\Http\Request;
use JavaScript;
use Pingpong\Modules\Routing\Controller;

class PecasController extends Controller {

	public function index(Request $request) {
		$lotes = Lote::all();
		$obras = Obra::has('importacoes')->where('status', 1)->get()->lists('nome', 'id');

		// CONSTRÓI O MENU DE NAVEGAÇÃO
		$nav = new NavigationController;
		$nav = $nav->buildnavigation($request);

		// $nav = session('navigation');

		if ($request->old('obra_id')) {
			$etapas = Obra::find($request->old('obra_id'))->etapas->lists('codigo', 'id');
		} else {
			$etapas = array();
		}

		$estagios = Estagio::where('tipo', '>', 1)->where('tipo', '<', 11)->orderBy('ordem')->get();

		$columns = array();
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
		return view('gestordelotes::pecas.index', compact('obras', 'lotes', 'etapas', 'estagios', 'nav'));
	}

}