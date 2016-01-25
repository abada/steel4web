<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;


class subetapas extends Model
{

	protected $fillable = ['codigoSubetapa', 'peso', 'tiposubetapa_id', 'observacao', 'etapa_id', 'user_id', 'locatario_id'];
    protected $table = 'subetapas';
    protected $primaryKey = 'id';

    public static function get_by_id($id)
    {
        $query = 	DB::table('subetapas')->select('*')
            ->where('id', $id)
             ->where('locatario_id',  access()->user()->locatario_id)
             ->get();

        if(count($query) > 0):
            return $query;
        endif;

        return false;
    }

    public static function get_by_field($field, $value, $limit = null)
    {
       $query = 	DB::table('subetapas')->select('*')
            ->where('locatario_id',  access()->user()->locatario_id)
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

    public static function get_all($etapa_id)
    {
         $query = 	DB::table('subetapas')->select('*')
            ->where('locatario_id',  access()->user()->locatario_id)
            ->where('etapa_id', $etapa_id)
            ->orderby('codigoSubetapa', 'asc')
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
