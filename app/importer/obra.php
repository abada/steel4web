<?php

namespace App\importer;
use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;

class obra extends Model
{

	protected $fillable = ['codigo', 'nome', 'descricao', 'cidadeID', 'endereco', 'cep', 'clienteID', 'construtoraID','gerenciadoraID', 'calculistaID', 'detalhamentoID', 'montagemID', 'data', 'status' ];
    protected $table = 'obras';
    protected $primaryKey = 'obraID';

     public static function get_all()
    {
        $query = 	DB::table('obras')
        			->select('obras.obraID', 'obras.codigo AS codigoObra', 'obras.nome AS nomeObra', 'obras.data', 'clientes.razao', 'clientes.fantasia', 'status')
        			 ->leftJoin('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
        			 ->where('clientes.locatarioID', access()->user()->locatarioID)
                    ->get();
        return $query;
    }

     public static function get_by_id($id)
    {
        $query = 	DB::table('obras')
                    ->select('*')
                    ->leftJoin('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
                    ->where('obraID', $id)
                    ->where('clientes.locatarioID',  access()->user()->locatarioID)
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
                            ->where('locatarioID',  access()->user()->locatarioID)
                    		->get();

            return $query;

	}

	public static function get_all_order()
    {
        $query = 	DB::table('obras')
        		->select('obras.obraID', 'obras.codigo AS codigoObra', 'obras.nome AS nomeObra', 'obras.data', 'clientes.razao', 'clientes.fantasia', 'status')
                ->leftJoin('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
                ->where('clientes.locatarioID', access()->user()->locatarioID)
                ->orderby('status', 'desc')->take(10)
                ->get();
        return $query;
    }

     public static function get_all_right(){
         $query = 	DB::table('obras')
         	->select('*')
            ->join('clientes', 'clientes.clienteID', '=', 'obras.clienteID')
            ->where('clientes.locatarioID', access()->user()->locatarioID)
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
            ->where('obraID', $id)
            ->update($attributes);

        if($data):
            return $data->id();
        endif;
        return false;
    }

    public static function del($id, $limit = null)
    {
       $data = DB::table('obras')->where('obraID',$id)->delete();

        if($data):
            return true;
        endif;
        return false;
    }

}