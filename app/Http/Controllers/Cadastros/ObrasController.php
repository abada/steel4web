<?php

namespace App\Http\Controllers\Cadastros;

use Illuminate\Http\Request;
use App\importer\obra;
use App\Obra as obr;
use App\Contato as cont;
use App\TipoContato as tipo;
use App\Cliente as client;
use App\Etapa as etap;
use App\Models\Access\User\User as users;
use App\importer\cliente;
use App\importer\contato;
use App\importer\etapa;
use App\importer\subetapas;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

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
        return view('frontend.cadastros.obras-listar',compact('obras'));
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

        return view('frontend.cadastros.obras-perfil',compact('obra', 'cliente', 'contatos','etapas'));
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
         return view('frontend.cadastros.obras-cadastro',compact('tipos', 'clientes', 'contatos','selIds'));
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
         
         return view('frontend.cadastros.obras-cadastro',compact('tipos', 'clientes', 'contatos', 'obra', 'edicao','sel','selIds'));
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
        $users = users::where('locatario_id', access()->user()->locatario_id)->get();

        /* Array of Roles that automatically gain permission to see the 3D */
        $alloweds = config('obra_users');

        foreach($users as $user){
            
            $y = 0;
            if($user->roles){
                foreach($user->roles as $role){
                    if(in_array($role->name, $alloweds)  && $y == 0){
                        $user->obrasPermitidas()->attach($obraID->id);
                        $y = 1;
                    }
                }
            }    
        }

        if(isset($obraID)){
            foreach($contes as $cano){
                if($cano != 'Selecione...'){
                $mario = array('obra_id' => $obraID->id, 'contato_id' => $cano);
                $obra_contato = $obraID->contatos()->attach(1, $mario);
            }
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

    public function excluir($id){
        $etapas = etap::where('obra_id', $id)->get();
            if(empty($etapas->first()->id)){
                 $obra = obr::find($id);
                 $name = $obra->nome;
                 $obra->delete();
                 $msg = 'Exclussão de Obra '.$name.' por '. access()->user()->name .'.';
                Log::info($msg);
                return redirect()->back()->withFlashSuccess('Obra excluida com Sucesso!');
            }else{
                return redirect()->back()->withFlashDanger('Erro ao excluir obra. Exclua todas as etapas antes de excluir uma obra.');
            }
    }

    public function editarStatus($id)
    {
        

        $mudancaStatus = obr::find($id);
        $status = $mudancaStatus->status;

        if ($status == 0) {
            $codStatus = 1;
        } else {
            $codStatus = 0;
        }

        $attributes = array(
            'status'  => $codStatus
        );

        $change = obr::find($id)->update($attributes);

       return redirect('obras');
    }

   
}
