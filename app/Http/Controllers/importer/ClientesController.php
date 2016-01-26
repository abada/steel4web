<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\importer\cliente;
use App\Cliente as client;
use App\Http\Controllers\Controller;

class ClientesController extends Controller
{
     public function cadastro()
    {
         return view('backend.importer.clientes-cadastro');
    }

    public function index()
    {
       
        $clientes = cliente::get_all('clientes');
        return view('backend.importer.clientes-listar',compact('clientes'));
    }

    public function editar($id)
    {
        $pagina            = 'clientes-cadastro';
        $data['clienteID'] = strip_tags(trim($id));
        $cliente   = cliente::get_by_id($id);
        if ($cliente->locatario_id != access()->user()->locatario_id) {
            return redirect()->route('clientes');
        }
        $edicao    = true;

       return view('backend.importer.clientes-cadastro',compact('cliente', 'edicao'));
    }

    public function ver($id)
    {
        $cliente   = cliente::get_by_id($id);
        $edicao = true;
        $disable = true;

        return view('backend.importer.clientes-cadastro',compact('cliente', 'edicao', 'disable'));
    }

     public function gravar(Request $request)
    {
    	
    	$dados = $request->all();

            $dados['locatario_id'] =access()->user()->locatario_id;
            $dados['user_id']   =access()->user()->id;
            $dados['fone'] = $dados['telefone'];
            unset($dados['telefone']);

            if(isset($dados['razao']) && isset($dados['fantasia']) && isset($dados['tipo']) && isset($dados['cep']) && isset($dados['inscricao']) && isset($dados['documento']) && isset($dados['fone']) && isset($dados['endereco']) && isset($dados['cidade'])) {


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
            unset($dados['id']);
               $clienteID =   client::where('id',$id)->update($dados);


                if($clienteID){
                    die('sucesso');
                }
            die('erro'); 
        }
}
