<?php namespace Modules\Api\Http\Controllers;

use App\Locatario;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;

class ApiController extends Controller {

	public function index(Request $request, $res_name = null, $res_id = null, $rel_one = null, $rel_one_id = null, $rel_two = null, $rel_two_id = null, $rel_three = null, $rel_three_id = null, $rel_four = null, $rel_four_id = null) {
		$status = array();

		$data = $request->all();

		$locatario = new Locatario;
		$locatario = $locatario->find(access()->user()->locatario_id);
		$resource = null;

		if ($res_name != null) {
			$resource = $locatario->{$res_name}; // EX: locatario->obras
			if (!$resource) {$resource = null;}
		}

		if ($res_id != null) {
			$resource = $resource->find($res_id); // EX: obras->find( XXX )
			if (!$resource) {$resource = null;}
		}

		if ($rel_one != null) {
			$resource = $resource->{$rel_one}; // EX: obra->etapas
			if (!$resource) {$resource = null;}
		}

		if ($rel_one_id != null) {
			$resource = $resource->find($rel_one_id); // EX: etapas->find( XXX )
			if (!$resource) {$resource = null;}
		}

		if ($rel_two != null) {
			$resource = $resource->{$rel_two}; // EX: etapa->subetapas
			if (!$resource) {$resource = null;}
		}

		if ($rel_two_id != null) {
			$resource = $resource->find($rel_two_id); // EX: subetapas->find( XXX )
			if (!$resource) {$resource = null;}
		}

		if ($rel_three != null) {
			$resource = $resource->{$rel_three}; // EX: subetapa->importacoes
			if (!$resource) {$resource = null;}
		}

		if ($rel_three_id != null) {
			$resource = $resource->find($rel_three_id); // EX: importacoes->find( XXX )
			if (!$resource) {$resource = null;}
		}

		if ($rel_four != null) {
			$resource = $resource->{$rel_four};
			if (!$resource) {$resource = null;}
		}

		if ($rel_four_id != null) {
			$resource = $resource->find($rel_four_id);
			if (!$resource) {$resource = null;}
		}

		if (isset($data['has'])) {
			$resource = $resource->filter(function ($item) use ($data) {
				return count($item->{$data['has']}) > 0;
			});
			$resource = collect($resource);
		}

		return $resource;
	}

}