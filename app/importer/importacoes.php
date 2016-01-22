<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;

class importacoes extends Model
{
    protected $fillable = ['name', 'password', 'email', 'status', 'locatarioID'];
    protected $table = 'importacoes';
    protected $primaryKey = 'importacaoID';

    function __construct()
    {
        parent::__construct();
    }

     public static function get_by_id($id)
    {
        $data = 	DB::table('importacoes')
       			->where('locatarioID',  access()->user()->locatarioID)
       			->where('importacaoID', $id)
       			->get();


         if($data):
            return $data;
        endif;
        return false;
    }

     public static function get_by_field($field, $value, $limit = null)
    {
        #Method Chaining APENAS PHP >= 5
       $data = 	DB::table('importacoes')
                    		->select('*')
                            ->where($field, $value)
                            ->where('locatarioID',  access()->user()->locatarioID)
                    		->get();

        if($data):
            return $data;
        endif;

        return false;
    }

    public static function get_all()
    {
         $data = 	DB::table('importacoes')
                		->select('obras.obraID', 'obras.codigo AS codigoObra', 'obras.nome AS nomeObra', 'obras.data', 'clientes.razao', 'clientes.fantasia')
                        ->leftJoin('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
                        ->where('locatarioID',  access()->user()->locatarioID)
                        ->get();

        return $query;
    }

     public static function get_all_list()
    {
      $data =  DB::table('importacoes')
                        ->where('locatarioID',  access()->user()->locatarioID)->get();
        return $data;
    } 

    public static function get_all_count(){
        $data =  DB::table('importacoes')
                        ->where('locatarioID',  access()->user()->locatarioID)->get();
        return $data;
    }

      public static function get_all_order()
    {
        $data =  DB::table('importacoes')
                        ->where('locatarioID',  access()->user()->locatarioID)
                        ->orderby('importacaoID', 'desc')->take(10)->get();
        return $data;
    }

    public static function get_names($subetapaID)
    {
       $data =  DB::table('subetapas')
       			->select('subetapas.codigoSubetapa', 'subetapas.etapaID', 'etapas.codigoEtapa', 'obras.nome', 'clientes.razao')
                ->leftJoin('etapas', 'etapas.etapaID', '=', 'subetapas.etapaID')
                ->leftJoin('obras', 'obras.obraID', '=', 'etapas.obraID')
                ->join('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
                ->where('subetapas.subetapaID', $subetapaID)
                ->where('clientes.locatarioID', access()->user()->locatarioID)
                ->get();

        return $data;
    }

    public static function get_dados($subetapaID)
    {
         $data =  DB::table('subetapas')
         		->select('subetapas.subetapaID', 'subetapas.etapaID', 'etapas.obraID', 'obras.clienteID', 'clientes.locatarioID')
                ->leftJoin('etapas', 'etapas.etapaID', '=', 'subetapas.etapaID')
                ->leftJoin('obras', 'obras.obraID', '=', 'etapas.obraID')
                ->join('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
                ->where('subetapas.subetapaID', $subetapaID)
                ->where('clientes.locatarioID', access()->user()->locatarioID)
                ->get();

        return $data;
    }

    public static function nro_importacao($subetapaID)
    {
         $data =  DB::table('importacoes')
         ->select('importacaoNr')
            ->where('subetapaID', $subetapaID)
            ->orderby('importacaoNr', 'desc')
            ->get();

        return $data;
    }

    public static function insert($attributes)
    {
       $data = DB::table('importacoes')->insert($attributes);
        if($data):
            return $data->id();
        endif;
    }

   

    public static function getCoords($mar, $qtd){
        $data =  DB::table('tbhandle')
            ->join('obras', 'obras.obraID', '=', 'tbhandle.obra')
            ->join('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
            ->where('clientes.locatarioID', access()->user()->locatarioID)
            ->where('MAR_PEZ', $mar)
            ->where('FLG_REC', 3)
            ->orderby('X', 'asc') //Mode XY, -XY would be (X DESC Y ASC), -X-Y would be (X DESC Y DESC) and X-Y would be (X ASC Y DESC)
            ->orderby('Y', 'asc')
            ->take($qtd)
        	->get();
        return $data;
    }

    public static function getConjuntos($id){
        $data =  DB::table('tbhandle')
        ->distinct('MAR_PEZ')
             ->where('FLG_REC', 3)
             ->where('fkimportacao', $id)
             ->groupby('MAR_PEZ')->get();
        return $data;
    }
}
