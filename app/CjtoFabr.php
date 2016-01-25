<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CjtoFabr extends Model {
	protected $table = 'cjtofabr';
	protected $fillable = ['lote_id', 'handle_id', 'user_id', 'locatario_id'];

	/**
	 * Get the LOTE of the model
	 * @return Relationship belongsTo
	 */
	public function lote() {
		return $this->belongsTo('App\Lote');
	}

	/**
	 * Get the LOTE of the model
	 * @return Relationship belongsTo
	 */
	public function handle() {
		return $this->belongsTo('App\Handle');
	}

	/**
	 * Get the USER (owner) of the model
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

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function cronogramas() {
		return $this->hasMany('App\Cronograma');
	}
}
