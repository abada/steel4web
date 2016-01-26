<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;

class cliente extends Model
{

	protected $fillable = ['razao', 'fantasia', 'user_id', 'documento', 'inscricao', 'cidade', 'fone', 'endereco', 'cep', 'email', 'site', 'locatario_id', 'tipo', 'responsavel'];
    protected $table = 'clientes';
    protected $primaryKey = 'id';

    public static function get_by_id($id)
    {
         $query = 	DB::table('clientes')
                    ->select('*')
                    ->where('id', $id)
                    ->where('locatario_id',  access()->user()->locatario_id)
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
                            ->where('locatario_id',  access()->user()->locatario_id)
                    		->get();

            return $query;

	}


    public static function get_all($tipoCliente=null)
    {
        	 $query = 	DB::table('clientes')
       			->where('locatario_id',  access()->user()->locatario_id)
          		->get();

        return $query;
    }

     public static function get_all_order($tipoCliente=null)
    {
       $query = 	DB::table('clientes')
        ->where('locatario_id',  access()->user()->locatario_id)
        ->orderby('id', 'desc')->take(10)
        ->get();
        return $query;
    }

}
