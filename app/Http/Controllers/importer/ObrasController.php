<?php

namespace App\Http\Controllers\importer;

use Illuminate\Http\Request;
use App\importer\obra;
use App\importer\cliente;
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
        $cliente      = cliente::get_by_id($obra->clienteID);
        $construtora  = cliente::get_by_id($obra->construtoraID);
        $gerenciadora = cliente::get_by_id($obra->gerenciadoraID);
        $calculista   = cliente::get_by_id($obra->calculistaID);
        $detalhamento = cliente::get_by_id($obra->detalhamentoID);
        $montagem     = cliente::get_by_id($obra->montagemID);
        $etapas       = etapa::get_all($id);
        $cont = sizeof($etapas) - 1;

        for ($i=0; $i < $cont; $i++) {
            $etapas[$i]->subetapas = subetapas::get_all($etapas[$i]->etapaID);
        }

        return view('backend.importer.obras-perfil',compact('obra', 'cliente', 'construtora', 'gerenciadora', 'calculista','detalhamento','montagem','etapas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
