<?php namespace Modules\Importador\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class ImportadorController extends Controller {
	
	public function index()
	{
		return view('importador::index');
	}
	
}