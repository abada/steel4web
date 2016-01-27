<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;
use App\importer\etapa;
use App\Etapa as etap;
use App\Subetapa as sub;
use App\importer\cliente;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EtapasController extends Controller
{
    public function cadastrar($obraID)
    {
        return view('backend.importer.etapas-cadastro',compact('obraID'));
    }

     public function editar($etapaID)
    {
        $edicao = true;
        $etapa  = etap::find($etapaID);

        return view('backend.importer.etapas-cadastro',compact('etapa', 'edicao'));
    }

    public function gravar(Request $request)
    {
    	
    	$dados = $request->all();

    		$dados['user_id']   =access()->user()->id;
            $dados['locatario_id'] =access()->user()->locatario_id;
            $dados['obra_id'] = (int)  $dados['obra_id'];
            $att = $dados;
               $clienteID = etap::create($att);
            $subAtt = array(
                'cod'               => 'estrutura',
                'peso'              => $clienteID->peso,
                'tiposubetapa_id'   => 1,
                'observacao'        => $dados['observacao'],
                'etapa_id'          => $clienteID->id,
                'user_id'           => $dados['user_id'],
                'locatario_id'      => $dados['locatario_id']
                );
            $subCreate = sub::create($subAtt);


                if($clienteID && $subCreate){
                    die('sucesso');
                }
            die('erro');
    }
}
