<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;

use App\Locatario as loc;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function index(){
		
	$id = access()->user()->locatario_id;
    $dados = loc::find($id);

     return view('backend.importer.dashboard',compact('dados'));
	}
    
}
