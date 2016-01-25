<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subetapa extends Model {
	protected $fillable = [
		'cod',
		'peso',
		'tiposubetapa_id',
		'observacao',
		'etapa_id',
		'user_id',
		'locatario_id',
	];
}
