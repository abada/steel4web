<?php namespace Modules\Gestordelotes\Http\Controllers;

use App\Cronograma;
use App\Handle;
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

		// $columns[] = ['data' => NULL, 'defaultContent' => '', 'className' => 'select-checkbox', 'orderable' => true];
		// $columns[] = ['data' => 'importacao_id'];
		// $columns[] = ['data' => 'lote'];
		// $columns[] = ['data' => 'MAR_PEZ'];
		// $columns[] = ['data' => 'FLG_DWG'];
		// $columns[] = ['data' => 'QTA_PEZ'];
		// $columns[] = ['data' => "DES_PEZ"];
		// $columns[] = ['data' => 'TRA_PEZ'];
		// $columns[] = ['data' => 'estagio'];

		$estagios = access()->user()->locatario->estagios->where('tipo', 2)->sortBy('ordem');

		$columns = array();
		foreach ($estagios as $estagio) {
			$columns[] = ['data' => 'ESTAGIO_' . $estagio->id];
		}

		JavaScript::put([
			'urlbase' => url('/'),
			'obra_id' => $request->old('obra_id'),
			'etapa_id' => $request->old('etapa_id'),
			'subetapa_id' => $request->old('subetapa_id'),
			'etapas' => $etapas,
			'selected' => $request->old('handles_ids'),
			'columns' => $columns,
		]);

		return view('gestordelotes::conjuntos.index', compact('obras', 'lotes', 'etapas', 'estagios'));
		// }
	}

	public function create(Request $request) {
		$data = $request->all();

		$obra_id = $data['obra_id'];
		$etapa_id = $data['etapa_id'];
		$subetapa_id = @$data['subetapa_id'];
		$grouped = @$data['grouped'];
		$conjuntos = @$data['handles_ids'];

		$estagios = access()->user()->locatario->estagios->where('tipo', 2)->sortBy('ordem');

		if ($request->ajax()) {
			// sleep(2);
			return view('gestordelotes::lotes.create-modal', compact('obra_id', 'etapa_id', 'subetapa_id', 'grouped', 'conjuntos', 'estagios'));
		} else {
			return view('gestordelotes::lotes.create');
		}
	}

	public function store(Request $request) {
		$data = $request->all();

		// dd($data);

		// Salva o lote
		$lote = Lote::create([
			'descricao' => @$data['descricao'],
			'obra_id' => @$data['obra_id'],
			'etapa_id' => @$data['etapa_id'],
			'subetapa_id' => @$data['subetapa_id'],
			'producao' => 0,
			'user_id' => access()->user()->id,
			'locatario_id' => access()->user()->locatario_id,
		]);

		if ($lote) {
			$request->session()->flash('flash_success', 'Lote criado com sucesso!');
			// $flash_success[] = 'Lote criado com sucesso!';
		} else {
			return back()->withFlashDanger('Erro! Não foi possível criar o lote.');
		}

		// Salva o Cronograma do Conjunto
		$conjuntos = array();

		foreach (@$data['conjuntos'] as $conjunto => $qtd) {

			$handle = Handle::where('MAR_PEZ', $conjunto)->where('FLG_REC', 3)->where('subetapa_id', $lote->subetapa_id)->first();

			if ($handle->importacao->sentido == 1) {
				$x = 'ASC';
				$y = 'ASC';
			} elseif ($handle->importacao->sentido == 2) {
				$x = 'DESC';
				$y = 'ASC';
			} elseif ($handle->importacao->sentido == 3) {
				$x = 'DESC';
				$y = 'DESC';
			} elseif ($handle->importacao->sentido == 4) {
				$x = 'ASC';
				$y = 'DESC';
			} else {
				return 'Falha ao Procurar Sentido de Construção.&ApDanger';
			}
			$handles_conjunto = Handle::where('MAR_PEZ', $conjunto)->where('lote_id', null)->where('FLG_REC', 3)->where('subetapa_id', $lote->subetapa_id)->orderBy('X', $x)->orderBy('Y', $y)->take($qtd)->get();

			foreach ($handles_conjunto as $handle) {

				// Atualiza HANDLE [lote]
				$handle->lote_id = $lote->id;
				$handle->save();

				$conjuntos[] = $handle->id;
			}
		}

		foreach ($data as $key => $value) {
			if (empty($value)) {
				unset($data[$key]);
			}
		}

		// CRIA CONJUNTO FABR
		// $data['lote_id'] = $lote->id;
		// $data['handle_id'] = $handle->id;
		// $data['user_id'] = access()->user()->id;
		// $data['locatario_id'] = access()->user()->locatario->id;

		// $cjt = CjtoFabr::create($data);
		// if (!$cjt) {
		// 	return back()->withFlashDanger('Erro! Não foi possível criar "CjtoFab"!');
		// }

		// CRIA CRONOGRAMA POR ESTÁGIOS
		$estagios = access()->user()->locatario->estagios->where('tipo', 2)->sortBy('ordem');
		$cronosaved = 0;
		foreach ($estagios as $estagio) {

			if (!empty($data['data_prev'][$estagio->id])) {

				$crono = new Cronograma;

				$crono->estagio_id = $estagio->id;
				$crono->lote_id = $lote->id;
				$crono->data_prev = $data['data_prev'][$estagio->id];
				$crono->data_real = null;
				$crono->version = 1;
				$crono->user_id = access()->user()->id;
				$crono->locatario_id = access()->user()->locatario->id;

				// SALVA CRONOGRAMA
				if ($crono->save()) {
					$cronosaved++;
				}
			}
		}
		// dd($crono);

		if ($cronosaved > 0) {
			$request->session()->flash('flash_success', 'Lote criado com sucesso!<br/>Conograma montado com sucesso!');
			// $flash_success[] = 'Conograma montado com sucesso!';
		} else {
			$request->session()->flash('flash_danger', 'Erro! Não foi possível montar o cronograma!');
		}
		return back();
	}

	public function lotes(Request $request) {
		dd($request->all());
	}

}