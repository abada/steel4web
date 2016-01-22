<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;


class etapa extends Model
{

	protected $fillable = ['codigoEtapa', 'peso', 'observacao', 'obra_ID'];
    protected $table = 'etapas';
    protected $primaryKey = 'etapaID';

    function __construct()
    {
        parent::__construct();
    }

    public static function get_by_id($id)
    {
       $query = 	DB::table('etapas')->select('*')
            ->leftJoin('obras', 'obras.obraID', '=', 'etapas.obraID')
            ->join('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
            ->where($this->tableID, $id)
            ->where('clientes.locatarioID', access()->user()->locatarioID)
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
            ->leftJoin('obras', 'obras.obraID', '=', 'etapas.obraID')
            ->leftJoin('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
            ->where('clientes.locatarioID', access()->user()->locatarioID)
            ->get();

        
            return $query;

    }

     public static function get_by_field2($field, $value)
    {

    	 $query = 	DB::table('etapas')
    		->select('*')
            ->where($field, $value)
            ->leftJoin('obras', 'obras.obraID', '=', 'etapas.obraID')
            ->leftJoin('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
            ->where('clientes.locatarioID', access()->user()->locatarioID)
            ->where('obras.'.$field, $value)
            ->get();

            return $query;
    }
    public static function get_all($obraID)
    {
       $query = DB::table('etapas')
            ->leftJoin('obras', 'obras.obraID', '=', 'etapas.obraID')
            ->leftJoin('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
            ->where('clientes.locatarioID',  access()->user()->locatarioID)
            ->where('etapas.obraID', $obraID)
            ->orderby('codigoEtapa', 'asc')
            ->get();

        return $query;
    }

    public static function insert($attributes)
    {	
    	$data = DB::table('etapas')->insert($attributes);
        if($data):
            return $data->id();
        endif;
    }
}
