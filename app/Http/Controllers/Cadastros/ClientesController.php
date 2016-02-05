<?php

namespace App\Http\Controllers\Cadastros;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\importer\cliente;
use App\Cliente as client;
use App\Http\Controllers\Controller;
use Log;

class ClientesController extends Controller
{
     public function cadastro()
    {
         return view('frontend.cadastros.clientes-cadastro');
    }

    public function index()
    {
       
        $clientes = cliente::get_all('clientes');
        return view('frontend.cadastros.clientes-listar',compact('clientes'));
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

       return view('frontend.cadastros.clientes-cadastro',compact('cliente', 'edicao'));
    }

    public function ver($id)
    {
        $cliente   = cliente::get_by_id($id);
        $edicao = true;
        $disable = true;

        return view('frontend.cadastros.clientes-cadastro',compact('cliente', 'edicao', 'disable'));
    }

     public function gravar(Request $request)
    {
    	
    	$dados = $request->all();

            $dados['locatario_id'] =access()->user()->locatario_id;
            $dados['user_id']   =access()->user()->id;
            $dados['fone'] = $dados['telefone'];
            unset($dados['telefone']);

            if(isset($dados['razao']) && isset($dados['tipo'])) {


                $clienteID = cliente::create($dados);


                if($clienteID){
                    $msg = 'Cadastro de Cliente: '.$dados['razao'].'. realizada por '. access()->user()->name .'.';
                    Log::info($msg);
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
                    $msg = 'Edição de Cliente: '.$dados['razao'].'. realizada por '. access()->user()->name .'.';
                    Log::info($msg);
                    die('sucesso');
                }
            die('erro'); 
        }
}
