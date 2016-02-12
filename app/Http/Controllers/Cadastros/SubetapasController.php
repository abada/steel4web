<?php

namespace App\Http\Controllers\Cadastros;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subetapa as sub;
use App\TipoSubetapa as tipo;
use App\Etapa as etap;
use App\Importacao as imp;
use Log;

class SubetapasController extends Controller
{
    public function cadastrar($etapaID)
    {
        $etapa = etap::find($etapaID);
        $obraID = $etapa->obra->id;
        $tipos = tipo::all();
        return view('frontend.cadastros.subetapas-cadastro',compact('etapaID','etapa', 'tipos','obraID'));
    }

    public function gravar(Request $request){
        $dados = $request->all();
        $dados['user_id']   =access()->user()->id;
        $dados['locatario_id'] =access()->user()->locatario_id;
        $att = $dados;
           $clienteID = sub::create($att);
        if($clienteID){
            $msg = 'Cadastro de Subetapa: '.$clienteID->cod.'. Realizada por '. access()->user()->name .'.';
            Log::info($msg);
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
            $msg = 'Edição de Subetapa: '.$dados['cod'].'. Realizada por '. access()->user()->name .'.';
            Log::info($msg);
            die('sucesso');
        }
     die('erro');
    }

    public function editar($etapaID)
    {
        $edicao = true;
        $subetapa  = sub::find($etapaID);
        $tipos = tipo::all();

        return view('frontend.cadastros.subetapas-cadastro',compact('subetapa', 'edicao','tipos','etapaID'));
    }

    public function tipos()
    {
        $tipos = tipo::all();
        $sub = true;

        return view('frontend.cadastros.tipos-contato',compact('tipos', 'sub'));
    }

    public function tipoCadastro(){
        $sub = true;
        return view('frontend.cadastros.tipos-cadastro',compact('sub'));
    }

    public function gravarTipo(Request $request){
        $dados = $request->all();
        $dados['locatario_id'] =access()->user()->locatario_id;
        $dados['user_id']   =access()->user()->id;
         $clienteID = tipo::create($dados);


                if($clienteID){
                    $msg = 'Cadastro de Tipo de Subetapa: '.$clienteID->descricao.'. Realizada por '. access()->user()->name .'.';
                    Log::info($msg);
                    die('sucesso');
                }
            die('erro');
    }

    public function tipoEditar($id){
        $tipo = tipo::find($id);
        $sub = true;
        $edicao    = true;

       return view('frontend.cadastros.tipos-cadastro',compact('edicao','tipo','sub')); 
    }

    public function tipoExcluir($id){
        $conts = sub::where('tiposubetapa_id',$id)->get();
        if(isset($conts[0])){
             \Session::flash('error', 'Tipo em uso, exclusão proibida.');
            return redirect()->route('subetapa/tipos');   
        }
        else{
           $del = tipo::find($id);
           $name = $del->descricao;
           $del->delete();
           $msg = 'Exclusão de Tipo de Subetapa: '.$name.'. Realizada por '. access()->user()->name .'.';
            Log::info($msg);
       //     \Session::flash('success', 'Tipo excluida com Sucesso.');
            return redirect()->back()->withFlashSuccess('Tipo excluida com Sucesso.');
            
        }

    }

    public function gravarTipoEdicao(Request $request){
        $dados = $request->all();

      $dados['locatario_id'] =access()->user()->locatario_id;
      $dados['user_id']   =access()->user()->id;

        $id = $dados['id'];

           $clienteID =   tipo::where('id',$id)->update($dados);

        if($clienteID){
            $msg = 'Edição de Tipo de Subetapa: '.$dados['descricao'].'. Realizada por '. access()->user()->name .'.';
            Log::info($msg);
            die('sucesso');
        }

    die('erro'); 
    }

      public function excluir(Request $request)
    {
        $dados = $request->all();
        $subID = $dados['id'];
        $checking = imp::where('subetapa_id', $subID)->get();
        if(empty($checking->first()->id)){
            $sub = sub::find($subID);
        $obraID = $sub->etapa->obra_id;
        if(count($sub->etapa->subetapas) > 1){
            $name = $sub->cod;
            $sub->delete();
            $msg = 'Exclusão de Subetapa: '.$name.'. Realizada por '. access()->user()->name .'.';
            Log::info($msg);
          die('sucesso'); 
        }
        else{
            die('erro2');
        }
    }else{
        die('erro3');
    }
        
        }
}