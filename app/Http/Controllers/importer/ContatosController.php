<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;
use App\importer\contato as cliente;
use App\Contato as cont;
use App\TipoContato as tipo;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContatosController extends Controller
{
    public function cadastro()
    {
    	 $contato = true;
         return view('backend.importer.clientes-cadastro',compact('contato'));
    }

    public function index()
    {
       	$contato = true;
        $clientes = cont::all();
        return view('backend.importer.clientes-listar',compact('clientes', 'contato'));
    }

    public function editar($id)
    {
        $tipos = tipo::all();
        $contato = true;
        $cliente   = cliente::get_by_id($id);
        if ($cliente->locatario_id != access()->user()->locatario_id) {
            return redirect()->route('clientes');
        }
        $edicao    = true;

       return view('backend.importer.clientes-cadastro',compact('cliente', 'edicao', 'contato','tipos'));
    }

    public function ver($id)
    {
        $tipos = tipo::all();
        $cliente   = cliente::get_by_id($id);
        if ($cliente->locatario_id != access()->user()->locatario_id) {
            return redirect()->route('clientes');
        }
        $edicao = true;
        $disable = true;
        $contato = true;

        return view('backend.importer.clientes-cadastro',compact('cliente', 'edicao', 'disable', 'contato','tipos'));
    }

    public function tipos()
    {
        $tipos = tipo::all();

        return view('backend.importer.tipos-contato',compact('tipos'));
    }

    public function tipoCadastro(){
        return view('backend.importer.tipos-cadastro');
    }

    public function gravarTipo(Request $request){
        $dados = $request->all();
        $dados['locatario_id'] =access()->user()->locatario_id;
        $dados['user_id']   =access()->user()->id;
         $clienteID = tipo::create($dados);


                if($clienteID){
                    die('sucesso');
                }
            die('erro');
    }

    public function tipoEditar($id){
        $tipo = tipo::find($id);
        $edicao    = true;

       return view('backend.importer.tipos-cadastro',compact('edicao','tipo')); 
    }

    public function tipoExcluir($id){
        $conts = cont::where('tipo_id',$id)->get();
        if(isset($conts[0])){
             \Session::flash('error', 'Categoria em uso, exclusão proibida.');
            return redirect()->route('contato/tipos');   
        }
        else{
           $del = tipo::find($id)->delete();
            \Session::flash('success', 'Categoria excluida com Sucesso.');
            return redirect()->route('contato/tipos');
            
        }

    }

    public function gravarTipoEdicao(Request $request){
        $dados = $request->all();

      $dados['locatario_id'] =access()->user()->locatario_id;
      $dados['user_id']   =access()->user()->id;

        $id = $dados['id'];

           $clienteID =   tipo::where('id',$id)->update($dados);

        if($clienteID){
            die('sucesso');
        }

    die('erro'); 
    }

     public function gravar(Request $request)
    {
    	
    	$dados = $request->all();

            $dados['locatario_id'] =access()->user()->locatario_id;
            $dados['user_id']   =access()->user()->id;
            $dados['cliente_id']   = 1;

           if(isset($dados['razao']) && isset($dados['fantasia']) && isset($dados['tipo']) && isset($dados['documento']) && isset($dados['telefone']) && isset($dados['endereco']) && isset($dados['locatario_id'])) {


               $clienteID = cliente::create($dados);


                if($clienteID){
                    die('sucesso');
                }
           }
            die('erro');
    }

     public function gravarEdicao(Request $request)
    {
       $dados = $request->all();

          $dados['locatario_id'] =access()->user()->locatario_id;
            $dados['user_id']   =access()->user()->id;
            $dados['fone'] = $dados['telefone'];
            unset($dados['telefone']);
            $id = $dados['id'];

               $clienteID =   cliente::where('id',$id)->update($dados);

            if($clienteID){
                die('sucesso');
            }

        die('erro'); 
    }
}
