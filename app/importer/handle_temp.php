<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;

class handle_temp extends Model
{
	protected $fillable = [
		'HANDLE',
		'FLG_REC',
		'NUM_COM',
		'DES_COM',
		'LOT_COM',
		'DLO_COM',
		'CLI_COM',
		'IND_COM',
		'DT1_COM',
		'DT2_COM',
		'NUM_DIS',
		'DES_DIS',
		'NOM_DIS',
		'REV_DIS',
		'DAT_DIS',
		'TRA_PEZ',
		'SBA_PEZ',
		'DES_SBA',
		'TIP_PEZ',
		'MAR_PEZ',
		'MBU_PEZ',
		'DES_PEZ',
		'POS_PEZ',
		'NOT_PEZ',
		'ING_PEZ',
		'MAX_LEN',
		'QTA_PEZ',
		'QT1_PEZ',
		'MCL_PEZ',
		'COD_PEZ',
		'COS_PEZ',
		'NOM_PRO',
		'LUN_PRO',
		'LAR_PRO',
		'SPE_PRO',
		'MAT_PRO',
		'TIP_BUL',
		'DIA_BUL',
		'LUN_BUL',
		'PRB_BUL',
		'PUN_LIS',
		'SUN_LIS',
		'PRE_LIS',
		'FLG_DWG',
		'obra',
		'id',
		'lote_id',
		'estagio_id',
		'GROUP',
		'fketapa',
		'CATE',
		'importacao_id',
		'preparacao_id',
		'medicao_id',
		'X',
		'Y',
		'Z',
		'A',
		'B',
		'user_id',
		'locatario_id'
	];

	protected $table = 'temp_handles';
    protected $primaryKey = 'id';

     public static function get_by_id($id)
    { 
    	$data = 	DB::table('temp_handles')
       			->where('locatario_id',  access()->user()->locatario_id)
       			->where('id', $id)
       			->get();


         if($data):
            return $data;
        endif;
        return false;
    }

    public static function get_by_field($field, $value, $limit = null)
    {
       $data = 	DB::table('temp_handles')->where($field, $value);

        if(!$limit == null){
           $data->take($limit);
        }

        $data = $data->get();

       if($data):
            return $data;
        endif;
        return false;
    }

    public static function get_all()
    {
       $data =  DB::table('temp_handles')
                        ->where('locatario_ID',  access()->user()->locatario_id)

                        ->get();
        return $data;
    }

        public static function insert($attributes)
    {
       $data = DB::table('temp_handles')->insert($attributes);
        if($data):
            return $data->id();
        endif;
    }

}

