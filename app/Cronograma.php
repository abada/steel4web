<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model {
	protected $table = 'cronos';

	protected $fillable = [
		'estagio_id',
		'cjtofab_id',
		'data_prev',
		'data_real',
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
	public function cjtofabr() {
		return $this->belongsTo('App\CjtoFabr', 'cjtofab_id');
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
