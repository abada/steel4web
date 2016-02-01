<?php namespace Modules\Api\Http\Controllers;

use App\Locatario;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;

class ApiController extends Controller {

	public function index(Request $request, $resource_name = null, $resource_id = null, $resource_relationship = null, $resource_relationship_id = null, $related_related_resource = null, $related_related_resource_id = null) {
		$status = array();

		// dd($request->all());
		$locatario = new Locatario;
		$locatario = $locatario->find(access()->user()->locatario_id);
		$resource = null;

		if ($resource_name != null) {
			$resource = $locatario->{$resource_name}; // EX: locatario->obras
			if (!$resource) {$resource = null;}
		}

		if ($resource_id != null) {
			$resource = $resource->find($resource_id); // EX: obras->find( XXX )
			if (!$resource) {$resource = null;}
		}

		if ($resource_relationship != null) {
			$resource = $resource->{$resource_relationship}; // EX: obra->etapas
			if (!$resource) {$resource = null;}
		}

		if ($resource_relationship_id != null) {
			$resource = $resource->find($resource_relationship_id); // EX: etapas->find( XXX )
			if (!$resource) {$resource = null;}
		}

		if ($related_related_resource != null) {
			$resource = $resource->{$related_related_resource}; // EX: obra->etapas
			if (!$resource) {$resource = null;}
		}

		if ($related_related_resource_id != null) {
			$resource = $resource->find($related_related_resource_id); // EX: etapas->find( XXX )
			if (!$resource) {$resource = null;}
		}

		dd($resource);
		return json_encode($resource);

		if ($resource) {

			if ($resource_id != null) {

				$resource = $resource->find($resource_id); // EX: obras->find( XXX )

				if ($resource && $resource_relationship != null && $resource->{$resource_relationship}) {
					// EX: obra->etapas

					$resource = $resource->{$resource_relationship};

					if ($resource && $resource_relationship_id != null) {

						$resource = $resource->find($resource_relationship_id);

						dd($resource);

						if ($related_related_resource != null && $resource->{$resource_relationship}->find($resource_relationship_id)->{$related_related_resource}) {

							$return = (count($resource) > 0) ? $resource : null;
							if ($request->ajax()) {return $return;} else {dd($return);}

						}

						$return = (count($resource) > 0) ? $resource : null;
						if ($request->ajax()) {return $return;} else {dd($return);}

					}

					$return = (count($resource) > 0) ? $resource : null;
					if ($request->ajax()) {return $return;} else {dd($return);}

				}

				// EX: return Obras
				$return = (count($resource) > 0) ? $resource : null;
				if ($request->ajax()) {return $return;} else {dd($return);}

			}

			$return = (count($resource) > 0) ? $resource : null;
			if ($request->ajax()) {return $return;} else {dd($return);}

		} else {
			$status['error'] = ':(';
			$return = $status;
			if ($request->ajax()) {return $return;} else {dd($status);}
		}

		if ($resource_id != null && $resource_name != null && $resource_relationship = null) {

			if ($resource) {
				$resource = $resource->find($resource_id);
				$status[$resource_name] = $resource;
				return $status;
			} else {
				$status['error'] = ':(';
				return $status;
			}

		} else
		if ($resource_id != null && $resource_name != null) {

			if ($resource) {
				$resource = $resource->find($resource_id);
				$status[$resource_name] = $resource;
				return $status;
			} else {
				$status['error'] = ':(';
				return $status;
			}

		} else
		if ($resource_name != null) {

			if ($resource) {
				$status[$resource_name] = $resource->toArray();
				return $status;
			} else {
				$status['error'] = ':(';
				return $status;
			}

		}

		$status['clientes'] = $request->user()->clients->toArray();
		$status['contatos'] = $request->user()->contacts->toArray();
		$status['obras'] = $request->user()->projects->toArray();
		$status['consultas-tecnicas'] = $request->user()->tecnhical_consults->toArray();

		return $status;
	}

}