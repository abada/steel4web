<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;


class subetapas extends Model
{

	protected $fillable = ['codigoSubetapa', 'peso', 'tipo', 'observacao', 'etapaID'];
    protected $table = 'subetapas';
    protected $primaryKey = 'subetapaID';

    public static function get_by_id($id)
    {
        $query = 	DB::table('subetapas')->select('subetapas.*')
            ->leftJoin('etapas', 'etapas.etapaID', '=', 'subetapas.etapaID')
            ->leftJoin('obras', 'obras.obraID', '=', 'etapas.obraID')
            ->leftJoin('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
            ->where('subetapaID', $id)
             ->where('clientes.locatarioID',  access()->user()->locatarioID)
             ->get();

        if(count($query) > 0):
            return $query;
        endif;

        return false;
    }

    public static function get_by_field($field, $value, $limit = null)
    {
       $query = 	DB::table('subetapas')->select('subetapas.*')
            ->leftJoin('etapas', 'etapas.etapaID', '=', 'subetapas.etapaID')
            ->leftJoin('obras', 'obras.obraID', '=', 'etapas.obraID')
            ->leftJoin('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
            ->where('clientes.locatarioID',  access()->user()->locatarioID)
            ->where($field, $value)
            ->get();

        if(!$limit == null){
            $this->db->limit($limit);
        }

        if(count($query) > 0):
            return $query;
        endif;

        return false;
    }

    public static function get_all($etapaID)
    {
         $query = 	DB::table('subetapas')->select('subetapas.*')
            ->leftJoin('etapas', 'etapas.etapaID', '=', 'subetapas.etapaID')
            ->leftJoin('obras', 'obras.obraID', '=', 'etapas.obraID')
            ->leftJoin('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
            ->where('clientes.locatarioID',  access()->user()->locatarioID)
            ->where('subetapas.etapaID', $etapaID)
            ->orderby('codigoEtapa', 'asc')
            ->get();

        if(count($query) > 0):
            return $query;
        endif;

        return false;
    }

    public static function insert($attributes)
    {	
    	$data = DB::table('subetapas')->insert($attributes);
        if($data):
            return $data->id();
        endif;
    }
}
