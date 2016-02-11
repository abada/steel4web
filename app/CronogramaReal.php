<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronogramaReal extends Model {
	protected $table = 'cronogramaReal';

	protected $fillable = [
		'estagio_id',
		'MAR_PEZ',
		'handle_id',
		'lote_id',
		'data',
		'user_id',
		'locatario_id',
	];
}
