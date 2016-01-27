<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subetapa as sub;
use App\TipoSubetapa as tipo;
use App\Etapa as etap;

class SubetapasController extends Controller
{
    public function cadastrar($etapaID)
    {
    	$etapa = etap::find($etapaID);
    	$obraID = $etapa->obra->id;
    	$tipos = tipo::all();
        return view('backend.importer.subetapas-cadastro',compact('etapaID', 'tipos','obraID'));
    }

    public function gravar(Request $request){
    	$dados = $request->all();
    	$dados['user_id']   =access()->user()->id;
        $dados['locatario_id'] =access()->user()->locatario_id;
        $att = $dados;
           $clienteID = sub::create($att);
        if($clienteID){
            die('sucesso');
        }
   	 die('erro');
    }

    public function gravarEdicao(Request $request){
    	$dados = $request->all();
    	$dados['user_id']   =access()->user()->id;
    	unset($dados['etapa_id']);
    	$id = $dados['id'];;
    	unset($dados['id']);
        $att = $dados;

        $clienteID = sub::find($id)->update($att);

        if($clienteID){
            die('sucesso');
        }
   	 die('erro');
    }

    public function editar($etapaID)
    {
        $edicao = true;
        $subetapa  = sub::find($etapaID);
        $tipos = tipo::all();

        return view('backend.importer.subetapas-cadastro',compact('subetapa', 'edicao','tipos','etapaID'));
    }

      public function excluir(Request $request)
    {
        $dados = $request->all();
        $subID = $dados['id'];
        $sub = sub::find($subID);
        $obraID = $sub->etapa->obra_id;
        if(count($sub->etapa->subetapas) > 1){
            $sub->delete();
          die('sucesso'); 
        }
        else{
            die('erro2');
        }
        }
}
