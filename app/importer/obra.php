<?php

namespace App\importer;
use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;

class obra extends Model
{

	protected $fillable = ['codigo', 'nome', 'descricao', 'cidade', 'endereco', 'cep', 'cliente_id', 'construtoraid','gerenciadoraid', 'calculistaid', 'detalhamentoid', 'montagemid', 'data', 'status', 'user_id', 'locatario_id' ];
    protected $table = 'obras';
    protected $primaryKey = 'id';

     public static function get_all()
    {
        $query = 	DB::table('obras')
        			->select('obras.id', 'obras.codigo AS codigoObra', 'obras.nome AS nomeObra', 'obras.created_at', 'clientes.razao', 'clientes.fantasia', 'status')
        			 ->leftJoin('clientes', 'clientes.id', '=', 'obras.cliente_id')
        			 ->where('obras.locatario_id', access()->user()->locatario_id)
                    ->get();
        return $query;
    }

     public static function get_by_id($id)
    {
        $query = 	DB::table('obras')
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
         $query = 	DB::table('obras')
                    		->select('*')
                            ->where($field, $value)
                            ->where('locatario_id',  access()->user()->locatario_id)
                    		->get();

            return $query;

	}

	public static function get_all_order()
    {
        $query = 	DB::table('obras')
        		->select('obras.id', 'obras.codigo AS codigoObra', 'obras.nome AS nomeObra', 'obras.data', 'clientes.razao', 'clientes.fantasia', 'status')
                ->leftJoin('clientes', 'clientes.id', '=', 'obras.clienteID')
                ->where('clientes.locatario_id', access()->user()->locatario_id)
                ->orderby('status', 'desc')->take(10)
                ->get();
        return $query;
    }

     public static function get_all_right(){
         $query = 	DB::table('obras')
         	->select('*')
            ->where('locatario_id', access()->user()->locatario_id)
            ->get();
        return $query;
    }

     public static function insert($attributes)
    {	
    	$data = DB::table('obras')->insert($attributes);
        if($data):
            return $data->id();
        endif;
    }

    public static function updat($id, $attributes)
    {
        $data = DB::table('obras')
            ->where('id', $id)
            ->update($attributes);

        if($data):
            return $data->id();
        endif;
        return false;
    }

    public static function del($id, $limit = null)
    {
       $data = DB::table('obras')->where('id',$id)->delete();

        if($data):
            return true;
        endif;
        return false;
    }

}