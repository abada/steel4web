<?php

namespace App\importer;
use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;

class locatarios extends Model
{
    

	protected $fillable = ['razao', 'fantasia', 'tipo', 'documento', 'inscricao', 'fone', 'cidade', 'endereco', 'cep', 'email', 'status', 'data'];
    protected $table = 'locatarios';
    protected $primaryKey = 'id';

     public static function get_all()
    {
        $query = 	DB::table('locatarios')
                    ->get();
        return $query;
    }

     public static function get_by_id($id)
    {
        $query = 	DB::table('locatarios')
                    ->select('*')
                    ->where('id', $id)
                    ->get();


        if(count($query) > 0):
            return $query;
        endif;

        return false;
    }

     public static function get_by_field($field, $value)
    {
         $query = 	DB::table('locatarios')
                    		->select('*')
                            ->where($field, $value)
                    		->get();

            return $query;

	}


     public static function insert($attributes)
    {	
    	$data = DB::table('locatarios')->insert($attributes);
        if($data):
            return $data->id();
        endif;
    }

}

