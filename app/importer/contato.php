<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;


class contato extends Model
{
    protected $fillable = ['razao', 'fantasia', 'user_id', 'documento', 'inscricao', 'fone', 'endereco', 'cep', 'email', 'site', 'locatario_id'];
    protected $table = 'contatos';
    protected $primaryKey = 'id';

    public static function get_by_id($id)
    {
         $query = 	DB::table('contatos')
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
         $query = 	DB::table('contatos')
                    		->select('*')
                            ->where($field, $value)
                            ->where('locatario_id',  access()->user()->locatario_id)
                    		->get();

            return $query;

	}


    public static function get_all($tipoCliente=null)
    {
        	 $query = 	DB::table('contatos')
       			->where('locatario_id',  access()->user()->locatario_id)
          		->get();

        return $query;
    }

     public static function get_all_order($tipoCliente=null)
    {
       $query = 	DB::table('contatos')
        ->where('locatario_id',  access()->user()->locatario_id)
        ->orderby('id', 'desc')->take(10)
        ->get();
        return $query;
    }
}
