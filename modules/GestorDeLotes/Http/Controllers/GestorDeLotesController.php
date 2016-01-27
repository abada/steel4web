<?php namespace Modules\Gestordelotes\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class GestorDeLotesController extends Controller {
	
	public function index()
	{
		return view('gestordelotes::index');
	}
	
}