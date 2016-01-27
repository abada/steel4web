<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;
use App\importer\obra;
use App\Obra as obr;
use App\Contato as cont;
use App\TipoContato as tipo;
use App\Cliente as client;
use App\Etapa as etap;
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
        $obra         = obr::find($id);
        $cliente      = cliente::get_by_id($obra->cliente_id);
        $contatos     = obr::find($id)->contatos;
      //  $cont = sizeof($etapas) - 1;
       // dd($obra->etapas[0]->subetapas);

      /*  for ($i=0; $i < $cont; $i++) {
            $etapas[$i]->subetapas = subetapas::get_all($etapas[$i]->id);
        } */

        return view('backend.importer.obras-perfil',compact('obra', 'cliente', 'contatos','etapas'));
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
        $dadinho['status'] = 1;
        $obraID = obr::create($dadinho);
        if(isset($obraID)){
            foreach($contes as $cano){
                $mario = array('obra_id' => $obraID->id, 'contato_id' => $cano);
                $obra_contato = $obraID->contatos()->attach(1, $mario);
            }
            die('sucesso');
        }

        die('erro');
    }

    public function update(Request $request){
        $dados = $request->all();
        $data = explode('&', $dados['dados']);
        $dadinho = array();
        $contes = array();
        $contes2 = array();
        $mario = array();
        $xx = 0;
        foreach($data as $dat){
            list($key,$value) = explode('=',$dat);
            if(strpos($key, 'X95c55e5759335f81907e08fe999ed1f8X')){
               $newKey = str_replace('X95c55e5759335f81907e08fe999ed1f8X', '', $key);
               $contes[$xx]['tipo'] = $newKey;
               $contes[$xx]['value'] = $value;
               $xx++;
            }else{
                $dadinho[$key] = urldecode($value);
            }
        }
        $dadinho['user_id']   =access()->user()->id;
        $id = $dadinho['id'];
        unset($dadinho['id']);
        $dadinho['status'] = 1;
        $ThatObra = obr::find($id);
        $ThatObra->update($dadinho);
        foreach($ThatObra->contatos as $contates){
            $contes2[] = $contates->tipo->id;
        }
        if(isset($ThatObra)){
            $y = 0;
            foreach($contes as $cano){
                
                if($cano['value'] != 'Selecione...'){
                    $mario[$y] = array('obra_id' => $id, 'contato_id' => $cano['value']);
                    $y++; 
                }
            }
            $delCO = $ThatObra->contatos()->where('obra_id',$id)->detach();
            $obra_contato = $ThatObra->contatos()->attach($mario);
            die('sucesso');
        }

        die('erro');
    }

   
}
