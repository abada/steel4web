<?php namespace Modules\Gestordelotes\Http\Controllers;

use App\Etapa;
use App\Obra;
use App\Subetapa;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;

class NavigationController extends Controller {

	public function buildnavigation(Request $request) {

		$data = $request->all();

		$navigation = array();
		$navigation['query'] = array();

		// Store in the SESSION
		if (null != @$data['obra']) {
			// $request->session()->forget('navigation');
			$obras = Obra::has('importacoes')->where('status', 1)->get()->lists('nome', 'id');
			if ($obras) {
				// $request->session()->forget('navigation.obras.all');
				$navigation['obras']['all'] = $obras->toArray();
				// $request->session()->put('navigation.obras.all', $obras->toArray());
			}
			// selected
			$obra = Obra::find($data['obra']);
			if ($obra) {
				$navigation['obras']['selected'] = $obra->id;
				$navigation['query']['obra'] = $obra->id;
				// $request->session()->forget('navigation.obras.selected');
				// $request->session()->put('navigation.obras.selected', $obra->id);
			}
		}

		// ETAPAS
		if (null != @$data['etapa']) {

			$etapas = Etapa::where('obra_id', $data['obra'])->lists('codigo', 'id');
			if ($etapas) {
				// $request->session()->forget('navigation.etapas.all');
				$navigation['etapas']['all'] = $etapas->toArray();
				// $request->session()->put('navigation.etapas.all', $etapas);
			}
			// selected
			$etapa = Etapa::find($data['etapa']);
			if ($etapa) {
				// $request->session()->forget('navigation.etapas.selected');
				$navigation['etapas']['selected'] = $etapa->id;
				$navigation['query']['etapa'] = $etapa->id;
				// $request->session()->put('navigation.etapas.selected', $etapa->id);
			}

		}

		// SUBETAPAS
		if (null != @$data['subetapa']) {

			$subetapas = Subetapa::where('etapa_id', $data['etapa'])->lists('cod', 'id');
			if ($subetapas) {
				// $request->session()->forget('navigation.subetapas.all');
				$navigation['subetapas']['all'] = $subetapas->toArray();
				// $request->session()->put('navigation.subetapas.all', $subetapas);
			}
			// selected
			$subetapa = Subetapa::find($data['subetapa']);
			if ($subetapa) {
				// $request->session()->forget('navigation.subetapas.selected');
				$navigation['subetapas']['selected'] = $subetapa->id;
				$navigation['query']['subetapa'] = $subetapa->id;
				// $request->session()->put('navigation.subetapas.selected', $subetapa->id);
			}
		}

		session('navigation', $navigation);

		if ($request->ajax()) {
			return json_encode($navigation);
		} else {
			return $navigation;
		}

	}

}