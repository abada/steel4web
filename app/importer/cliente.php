<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;

class cliente extends Model
{

	protected $fillable = ['razao', 'fantasia', 'tipo', 'documento', 'inscricao', 'fone', 'endereco', 'cep', 'email', 'site', 'locatarioID', 'tipoContato'];
    protected $table = 'clientes';
    protected $primaryKey = 'clienteID';

    public static function get_by_id($id)
    {
         $query = 	DB::table('clientes')
                    ->select('*')
                    ->where('clienteID', $id)
                    ->where('locatarioID',  access()->user()->locatarioID)
                    ->get();


        if(count($query) > 0):
            return $query[0];
        endif;

        return false;
    }

    public static function get_by_field($field, $value)
    {
         $query = 	DB::table('clientes')
                    		->select('*')
                            ->where($field, $value)
                            ->where('locatarioID',  access()->user()->locatarioID)
                    		->get();

            return $query;

	}


    public static function get_all($tipoCliente=null)
    {
        if($tipoCliente == 'clientes'){
        	 $query = 	DB::table('clientes')
       			->where('locatarioID',  access()->user()->locatarioID)
          		->where('cliente', 1)->get();
        } else {
              	 $query = 	DB::table('clientes')
       			->where('locatarioID',  access()->user()->locatarioID)
          		->where('cliente', null)->get();
        }
        return $query;
    }

     public static function get_all_order($tipoCliente=null)
    {
       $query = 	DB::table('clientes')
        ->where('locatarioID',  access()->user()->locatarioID)
        ->orderby('data', 'desk')->take(10)
        ->get();
        return $query;
    }

   public static function insert($attributes)
    {	
    	$data = DB::table('clientes')->insert($attributes);
        if($data):
            return $data->id();
        endif;
    }

    public static function updat($id, $attributes)
    {
        $data = DB::table('clientes')
            ->where('clienteID', $id)
            ->update($attributes);

        if($data):
            return $data->id();
        endif;
        return false;
    }

    public static function del($id, $limit = null)
    {
       $data = DB::table('clientes')->where('clienteID',$id)->delete();

        if($data):
            return true;
        endif;
        return false;
    }
}
