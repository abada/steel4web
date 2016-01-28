<?php

namespace App\Http\Controllers\Cadastros;

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
         $tipos = tipo::all();
         $contato = true;
         return view('frontend.cadastros.clientes-cadastro',compact('contato','tipos'));
    }

    public function index()
    {
        $contato = true;
        $clientes = cont::all();
        return view('frontend.cadastros.clientes-listar',compact('clientes', 'contato'));
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

       return view('frontend.cadastros.clientes-cadastro',compact('cliente', 'edicao', 'contato','tipos'));
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

        return view('frontend.cadastros.clientes-cadastro',compact('cliente', 'edicao', 'disable', 'contato','tipos'));
    }

    public function tipos()
    {
        $tipos = tipo::all();

        return view('frontend.cadastros.tipos-contato',compact('tipos'));
    }

    public function tipoCadastro(){
        return view('frontend.cadastros.tipos-cadastro');
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

       return view('frontend.cadastros.tipos-cadastro',compact('edicao','tipo')); 
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
            $dados['fone'] = $dados['telefone'];
            unset($dados['telefone']);

           if(isset($dados['razao']) && isset($dados['tipo_id']) && isset($dados['email']) && isset($dados['fone']) && isset($dados['endereco']) && isset($dados['cep']) && isset($dados['cidade'])) {


               $clienteID = cont::create($dados);


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

            if(isset($dados['razao']) && isset($dados['tipo_id']) && isset($dados['email']) && isset($dados['fone']) && isset($dados['endereco']) && isset($dados['cep']) && isset($dados['cidade'])) {

               $clienteID =   cliente::where('id',$id)->update($dados);

            if($clienteID){
                die('sucesso');
            }
            
            }
        die('erro'); 
    }
}