<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{	
	protected $table = 'etapas';
	public $timestamps = true;
	protected $fillable = [
	    'codigo',
	    'peso',
	    'obra_id',
	    'user_id',
	    'locatario_id',
	];
}
