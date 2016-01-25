<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;
use App\importer\etapa;
use App\Etapa as etap;
use App\importer\cliente;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EtapasController extends Controller
{
    public function cadastrar($obraID)
    {
        return view('backend.importer.etapas-cadastro',compact('obraID'));
    }

    public function gravar(Request $request)
    {
    	
    	$dados = $request->all();

    		$dados['user_id']   =access()->user()->id;
            $dados['locatario_id'] =access()->user()->locatario_id;
            $dados['obra_id'] = (int)  $dados['obra_id'];
           unset($dados['observacao']);
            $att = $dados;
               $clienteID = etap::create($att);


                if($clienteID){
                    die('sucesso');
                }
            die('erro');
    }
}
