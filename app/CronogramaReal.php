<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronogramaReal extends Model {
	protected $table = 'cronogramaReal';

	protected $fillable = [
		'estagio_id',
		'cjtofab_id',
		'handle_id',
		'data',
		'user_id',
		'locatario_id',
	];
}
