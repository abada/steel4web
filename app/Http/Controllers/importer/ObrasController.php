<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;
use App\importer\obra;
use App\Obra as obr;
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
         $clientes = client::all();
         return view('backend.importer.obras-cadastro',compact('tipos', 'clientes'));
    }

   
}
