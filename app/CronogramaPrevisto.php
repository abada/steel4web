<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronogramaPrevisto extends Model {
	protected $table = 'cronogramaprev';

	protected $fillable = [
		'estagio_id',
		'lote_id',
		'data',
		'version',
		'user_id',
		'locatario_id',
	];

	/**
	 * Get the Estagio for the model.
	 */
	public function estagio() {
		return $this->belongsTo('App\Estagio');
	}

	/**
	 * Get the Estagio for the model.
	 */
	public function lote() {
		return $this->belongsTo('App\Lote', 'lote_id');
	}

	/**
	 * Get the User (owner) of the model
	 * @return Relationship belongsTo
	 */
	public function user() {
		return $this->belongsTo('App\Model\Access\User\User');
	}

	/**
	 * Get the LOCATÁRIO (company of users) of the model
	 * @return Relationship belongsTo
	 */
	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}
}
