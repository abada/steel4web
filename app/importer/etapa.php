<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;


class etapa extends Model
{

	protected $fillable = ['codigo', 'peso', 'user_id', 'obra_id', 'locatario_id', 'observacao'];
    protected $table = 'etapas';
    protected $primaryKey = 'id';

    function __construct()
    {
        parent::__construct();
    }

    public static function get_by_id($id)
    {
       $query = 	DB::table('etapas')->select('*')
            ->leftJoin('obras', 'obras.id', '=', 'etapas.obra_id')
            ->join('clientes', 'clientes.id', '=', 'obras.cliente_id')
            ->where('id', $id)
            ->where('clientes.locatario_id', access()->user()->locatario_id)
            ->get();

       if($query):
            return $query[0];
        endif;

        return false;
    }

    public static function get_by_field($field, $value, $limit = null)
    {
         $query = 	DB::table('etapas')
    		->select('*')
            ->where($field, $value)
            ->leftJoin('obras', 'obras.id', '=', 'etapas.obra_id')
            ->leftJoin('clientes', 'clientes.id', '=', 'obras.cliente_id')
            ->where('clientes.locatario_id', access()->user()->locatario_id)
            ->get();

        
            return $query;

    }

     public static function get_by_field2($field, $value)
    {

    	 $query = 	DB::table('etapas')
    		->select('*')
            ->leftJoin('obras', 'obras.id', '=', 'etapas.obra_id')
            ->leftJoin('clientes', 'clientes.id', '=', 'obras.cliente_id')
            ->where('clientes.locatario_id', access()->user()->locatario_id)
            ->where('obras.'.$field, $value)
            ->get();

            return $query;
    }
    public static function get_all($obra_id)
    {
       $query = DB::table('etapas')
            ->select('*')
            ->where('locatario_id',  access()->user()->locatario_id)
            ->where('obra_id', $obra_id)
            ->orderby('codigo', 'asc')
            ->get();

        return $query;
    }

}
