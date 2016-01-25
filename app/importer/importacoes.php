<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;

class importacoes extends Model
{
    protected $fillable = ['name', 'password', 'email', 'status', 'locatario_id'];
    protected $table = 'importacoes';
    protected $primaryKey = 'id';

    function __construct()
    {
        parent::__construct();
    }

     public static function get_by_id($id)
    {
        $data = 	DB::table('importacoes')
       			->where('locatario_id',  access()->user()->locatario_id)
       			->where('id', $id)
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
                            ->where('locatario_id',  access()->user()->locatario_id)
                    		->get();

        if($data):
            return $data;
        endif;

        return false;
    }

    public static function get_all()
    {
         $data = 	DB::table('importacoes')
                		->select('obras.id', 'obras.codigo AS codigoObra', 'obras.nome AS nomeObra', 'obras.data', 'clientes.razao', 'clientes.fantasia')
                        ->leftJoin('clientes', 'clientes.id', '=', 'obras.cliente_id')
                        ->where('locatario_id',  access()->user()->locatario_id)
                        ->get();

        return $query;
    }

     public static function get_all_list()
    {
      $data =  DB::table('importacoes')
                        ->where('locatario_id',  access()->user()->locatario_id)->get();
        return $data;
    } 

    public static function get_all_count(){
        $data =  DB::table('importacoes')
                        ->where('locatario_id',  access()->user()->locatario_id)->get();
        return $data;
    }

      public static function get_all_order()
    {
        $data =  DB::table('importacoes')
                        ->where('locatario_id',  access()->user()->locatario_id)
                        ->orderby('id', 'desc')->take(10)->get();
        return $data;
    }

    public static function get_names($subetapaID)
    {
       $data =  DB::table('subetapas')
       			->select('subetapas.codigoSubetapa', 'subetapas.etapa_id', 'etapas.codigo', 'obras.nome', 'clientes.razao')
                ->leftJoin('etapas', 'etapas.id', '=', 'subetapas.etapa_id')
                ->leftJoin('obras', 'obras.id', '=', 'etapas.obra_id')
                ->join('clientes', 'clientes.id', '=', 'obras.cliente_id')
                ->where('subetapas.id', $subetapaID)
                ->where('clientes.locatario_id', access()->user()->locatario_id)
                ->get();

        return $data;
    }

    public static function get_dados($subetapaID)
    {
         $data =  DB::table('subetapas')
         		->select('subetapas.id', 'subetapas.etapa_id', 'etapas.obra_id', 'obras.cliente_id', 'clientes.locatario_id')
                ->leftJoin('etapas', 'etapas.id', '=', 'subetapas.etapa_id')
                ->leftJoin('obras', 'obras.id', '=', 'etapas.obra_id')
                ->join('clientes', 'clientes.id', '=', 'obras.cliente_id')
                ->where('subetapas.subetapa_id', $subetapaID)
                ->where('clientes.locatario_id', access()->user()->locatario_id)
                ->get();

        return $data;
    }

    public static function nro_importacao($subetapaID)
    {
         $data =  DB::table('importacoes')
         ->select('importacaoNr')
            ->where('subetapa_id', $subetapaID)
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
        $data =  DB::table('handles')
            ->join('obras', 'obras.id', '=', 'handles.obra')
            ->join('clientes', 'clientes.id', '=', 'obras.cliente_id')
            ->where('clientes.locatario_id', access()->user()->locatario_id)
            ->where('MAR_PEZ', $mar)
            ->where('FLG_REC', 3)
            ->orderby('X', 'asc') //Mode XY, -XY would be (X DESC Y ASC), -X-Y would be (X DESC Y DESC) and X-Y would be (X ASC Y DESC)
            ->orderby('Y', 'asc')
            ->take($qtd)
        	->get();
        return $data;
    }

    public static function getConjuntos($id){
        $data =  DB::table('handles')
        ->distinct('MAR_PEZ')
             ->where('FLG_REC', 3)
             ->where('importacao_id', $id)
             ->groupby('MAR_PEZ')->get();
        return $data;
    }
}
