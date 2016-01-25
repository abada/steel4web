<?php

namespace App\importer;

use DB;

use Illuminate\Database\Eloquent\Model;
use Auth;

class log extends Model
{
    protected $fillable = ['acao', 'query', 'user_id', 'data', 'locatario_id'];
    protected $table = 'logs';
    protected $primaryKey = 'id';

    public static function gravar($mensagem)
    {
        $attributes = array(
            'acao'        => $mensagem,
            'usuarioID'   => $this->session->userdata('usuarioID'),
            'locatarioID' => $this->session->userdata('locatarioID'),
            'query'       => $this->db->last_query(),
            'data'        => date('Y-m-d H:i:s')
        );

        $log = DB::create($attributes);
    }
}
