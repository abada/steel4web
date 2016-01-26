<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;
use App\importer\obra;
use App\Obra as obr;
use App\Contato as cont;
use App\TipoContato as tipo;
use App\Cliente as client;
use App\importer\cliente;
use App\importer\contato;
use App\importer\etapa;
use App\importer\subetapas;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ObrasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obras=obra::get_all();
        return view('backend.importer.obras-listar',compact('obras'));
    }

    public function ver($id)
    {
        $obra         = obra::get_by_id($id);
        $cliente      = cliente::get_by_id($obra->cliente_id);
        $construtora  = contato::get_by_id($obra->construtoraid);
        $gerenciadora = contato::get_by_id($obra->gerenciadoraid);
        $calculista   = contato::get_by_id($obra->calculistaid);
        $detalhamento = contato::get_by_id($obra->detalhamentoid);
        $montagem     = contato::get_by_id($obra->montagemid);
        $etapas       = etapa::get_all($id);
        $cont = sizeof($etapas) - 1;

        for ($i=0; $i < $cont; $i++) {
            $etapas[$i]->subetapas = subetapas::get_all($etapas[$i]->id);
        }

        return view('backend.importer.obras-perfil',compact('obra', 'cliente', 'construtora', 'gerenciadora', 'calculista','detalhamento','montagem','etapas'));
    }

    public function cadastro()
    {
         $tipos = tipo::all();
          $selIds = array();
         
         $clientes = client::all();
         $contatos = cont::all();
         foreach($contatos as $contat){
            $selIds[] = $contat->tipo_id;
         }
         return view('backend.importer.obras-cadastro',compact('tipos', 'clientes', 'contatos','selIds'));
    }

    public function editar($id)
    {
         $edicao = true;
         $tipos = tipo::all();
         $clientes = client::all();
         $contatos = cont::all();
         $obra = obr::find($id);
         $selected= array();
         $selIds = array();
         $sel= array();
         foreach($contatos as $contat){
            $selIds[] = $contat->tipo_id;
         }
         foreach($obra->contatos as $contato){
            
            $selected[]['contato'] = $contato->pivot->contato_id;
         }
         for($x=0;$x<count($selected);$x++){
            $sel[] = cont::find($selected[$x]['contato']);
         }
         
         return view('backend.importer.obras-cadastro',compact('tipos', 'clientes', 'contatos', 'obra', 'edicao','sel','selIds'));
    }

    public function gravar(Request $request){
        $dados = $request->all();
        $data = explode('&', $dados['dados']);
        $dadinho = array();
        $contes = array();
        foreach($data as $dat){
            list($key,$value) = explode('=',$dat);
            if(strpos($key, 'X95c55e5759335f81907e08fe999ed1f8X')){
               $newKey = str_replace('X95c55e5759335f81907e08fe999ed1f8X', '', $key);
               $contes[$newKey] = $value;
            }else{
                $dadinho[$key] = urldecode($value);
            }
        }
        $dadinho['locatario_id'] =access()->user()->locatario_id;
        $dadinho['user_id']   =access()->user()->id;
        $obraID = obr::create($dadinho);

        foreach($contes as $cano){
            $mario = array('obra_id' => $obraID, 'contato_id' => $cano);
            $dxd = ////CREATE THE FUCKIN OBRA_CONTATO MODEL AND INSERT MARIO IN THE FECKING DB USEING THA WANKER
        }
    }

   
}
