<?php namespace Modules\Gantt\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class GanttController extends Controller {
	
	public function index()
	{
		return view('gantt::index');
	}
	
}