<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;

class usuarios extends Model
{
    protected $fillable = ['name', 'password', 'email', 'status', 'locatarioID'];
    protected $table = 'users';
    protected $primaryKey = 'id';

    public static function get_by_id($id)
    {
        $data = 	DB::table('users')
       			->where('locatarioID',  access()->user()->locatarioID)
       			->where('id', $id)
       			->get();


         if($data):
            return $data;
        endif;
        return false;
    }

    public static function get_by_field($field, $value, $limit = null)
    {
        #Method Chaining APENAS PHP >= 5
       $data = 	DB::table('users')
                    		->select('*')
                            ->where($field, $value)
                            ->where('locatarioID',  access()->user()->locatarioID)
                    		->get();

        if($data):
            return $data;
        endif;

        return false;
    }

    public static function get_all()
    {
        #Method Chaining APENAS PHP >= 5
         $data = 	DB::table('users')
                    		->select('*')
                    		->where('locatarioID',  access()->user()->locatarioID)
                    		->get();

       if($data):
            return $data;
        endif;

        return false;
    }

    public static function get_all_order()
    {
         $data = 	DB::table('users')
                    		->select('*')
                    		->where('locatarioID',  access()->user()->locatarioID)
                    		->order_by('id', 'desc')->take(10)->get();
       
        return $data;
    }

     public static function insert($attributes)
    {	
    	$data = DB::table('users')->insert($attributes);
        if($data):
            return $data->id();
        endif;
    }
}
