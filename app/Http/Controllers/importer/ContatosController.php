<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;
use App\importer\contato as cliente;
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
        $clientes = cliente::get_all('clientes');
        return view('backend.importer.clientes-listar',compact('clientes', 'contato'));
    }

    public function editar($id)
    {
        $contato = true;
        $cliente   = cliente::get_by_id($id);
        if ($cliente->locatario_id != access()->user()->locatario_id) {
            return redirect()->route('clientes');
        }
        $edicao    = true;

       return view('backend.importer.clientes-cadastro',compact('cliente', 'edicao', 'contato'));
    }

    public function ver($id)
    {
        $cliente   = cliente::get_by_id($id);
        if ($cliente->locatario_id != access()->user()->locatario_id) {
            return redirect()->route('clientes');
        }
        $edicao = true;
        $disable = true;

        return view('backend.importer.clientes-cadastro',compact('cliente', 'edicao', 'disable'));
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
            unset($dados['user_id']);
               $clienteID =   cliente::where('id',$id)->update($dados);


                if($clienteID){
                    die('sucesso');
                }
            die('erro'); 
        }
}
