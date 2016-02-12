<?php

namespace App\Http\Controllers\Cadastros;

use Illuminate\Http\Request;
use App\importer\etapa;
use App\Etapa as etap;
use App\Subetapa as sub;
use App\Obra as obr;
use App\importer\cliente;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

class EtapasController extends Controller
{
    public function cadastrar($obraID)
    {
        $obra = obr::find($obraID);
        return view('frontend.cadastros.etapas-cadastro',compact('obraID', 'obra'));
    }

     public function editar($etapaID)
    {
        $edicao = true;
        $etapa  = etap::find($etapaID);

        return view('frontend.cadastros.etapas-cadastro',compact('etapa', 'edicao'));
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
                'cod'               => $clienteID->codigo.'-A',
                'peso'              => $clienteID->peso,
                'tiposubetapa_id'   => 1,
                'observacao'        => $dados['observacao'],
                'etapa_id'          => $clienteID->id,
                'user_id'           => $dados['user_id'],
                'locatario_id'      => $dados['locatario_id']
                );
            $subCreate = sub::create($subAtt);


                if($clienteID && $subCreate){
                    $msg = 'Cadastro de Etapa: '.$dados['codigo'].'. realizada por '. access()->user()->name .'.';
                    Log::info($msg);
                    die('sucesso');
                }
            die('erro');
    }

    public function gravarEdicao(Request $request)
    {
        
        $dados = $request->all();

            $dados['user_id']   =access()->user()->id;
            $ID = (int)  $dados['obra_id'];
            $id = $dados['etapaID'];
            unset($dados['etapaID']);
            unset($dados['obra_id']);
            $att = $dados;
            $clienteID = etap::find($id);
            $clienteID->update($att);
            $subEdit = sub::where('etapa_id',$id)->where('tiposubetapa_id',1);
            $subAtt = array(
                'peso'              => $clienteID->peso,
                'tiposubetapa_id'   => 1,
                'observacao'        => $dados['observacao'],
                'user_id'           => $dados['user_id']
                );
            $subCreate = $subEdit->update($subAtt);


                if($clienteID && $subCreate){
                    $msg = 'Edição de Etapa: '.$clienteID->codigo.'. realizada por '. access()->user()->name .'.';
                    Log::info($msg);
                    die('sucesso');
                }
            die('erro');
    }

    public function excluir(Request $request)
    {
        $dados = $request->all();
        $etapaID = $dados['id'];
        $etapa = etap::find($etapaID);
        $name = $etapa->codigo;
        $subs = sub::where('etapa_id', $etapaID)->get();
        foreach($subs as $sub){
            if(!empty($sub->importacoes->first()->id)){
                die('erro') ; 
            }
        }
        $obraID = $etapa->obra_id;
        if(count($etapa->subetapas) > 1){
            die('erro') ; 
        }
        else{
          $etapa->delete();
          $msg = 'Exclusão de Etapa: '.$name.'. realizada por '. access()->user()->name .'.';
          Log::info($msg);
          die('sucesso');
            
        }
        }
       
}
