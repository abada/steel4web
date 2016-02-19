<?php namespace Modules\Gestordelotes\Http\Controllers;

use App\Cronograma;
use App\Estagio;
use App\Handle;
use App\Lote;
use App\Obra;
use Illuminate\Http\Request;
use JavaScript;
use Pingpong\Modules\Routing\Controller;

class GestorDeLotesController extends Controller {

	public function index(Request $request) {

		$data = $request->all();

		$lotes = Lote::all();
		$obras = Obra::has('importacoes')->where('status', 1)->get();
		$obras = $obras->lists('nome', 'id');

		// CONSTRÓI O MENU DE NAVEGAÇÃO
		$nav = new NavigationController;
		$nav = $nav->buildnavigation($request);

		// $nav = session('navigation');

		if ($request->old('obra_id')) {
			$etapas = Obra::find($request->old('obra_id'))->etapas->lists('codigo', 'id');
		} else {
			$etapas = array();
		}

		$estagios = access()->user()->locatario->estagios->where('tipo', '>', 1)->where('tipo', '<', 11)->sortBy('ordem');

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

		return view('gestordelotes::conjuntos.index', compact('obras', 'lotes', 'etapas', 'estagios', 'nav'));
		// }
	}

	public function create(Request $request) {
		$data = $request->all();

		$obra_id = $data['obra_id'];
		$etapa_id = $data['etapa_id'];
		$subetapa_id = @$data['subetapa_id'];
		$grouped = @$data['grouped'];
		$conjuntos = @$data['handles_ids'];

		$estagios = Estagio::where('tipo', '>', 1)->where('tipo', '<', 11)->orderBy('ordem')->get();

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

		// CRIA CRONOGRAMA POR ESTÁGIOS
		$estagios = Estagio::where('tipo', '>', 1)->where('tipo', '<', 11)->orderBy('ordem')->get();
		//$estagios = access()->user()->locatario->estagios->whereBetween('tipo', [2, 10])->sortBy('ordem');
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

		$conjuntos = array();
		$estagios = $lote->estagios();

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
				$handle->estagio_id = $estagios->first()->id;
				$handle->save();

				$conjuntos[] = $handle->id;
			}
		}

		foreach ($data as $key => $value) {
			if (empty($value)) {
				unset($data[$key]);
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

	/**
	 * [associar description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function associaraolote(Request $request, $id = null) {

		$data = $request->all();

		$data['id'] = $id;
		$lote = Lote::find($id);
		if (!$lote) {
			return "Lote não encontrado!";
		}

		$conjuntos = array();

		foreach (@$data['handles_ids'] as $conjunto => $qtd) {

			// Pega o promeiro handle só pra pegar a importação, para obter as sequencia de montagem
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

			// Pega todos os handles à serem alterados de lote
			$handles_conjunto = Handle::where('MAR_PEZ', $conjunto)
				->where('lote_id', null)
				->where('FLG_REC', 3)
				->orderBy('X', $x)
				->orderBy('Y', $y)
				->take($qtd)
				->get();

			// Para cada handle...
			foreach ($handles_conjunto as $h) {

				// Atualiza HANDLE [lote]
				$h->lote_id = $id;
				$h->estagio_id = $lote->estagios()->first()->id;
				$h->save();

				$conjuntos[] = $h->id;
			}

			//Remove lotes vazios
			$lotes = access()->user()->locatario->lotes;
			foreach ($lotes as $lote) {
				if (count($lote->handles) < 1) {
					$lote->delete();
				}
			}

		}

		return json_encode($conjuntos);
	}

}