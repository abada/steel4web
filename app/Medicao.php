<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicao extends Model {

	protected $table = 'medicoes';

	protected $fillable = ['descricao', 'periodo', 'montador', 'obs', 'etapa_id', 'user_id', 'locatario_id'];

	/**
	 * Get the Etapa of the model
	 * @return Relationship belongsTo
	 */
	public function etapa() {
		return $this->belongsTo('App\Etapa');
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

	// REVERSE RELATIONSHIPS...

	/**
	 * Get the related Model
	 * @return Relationship hasMany
	 */
	public function cjtomontagem() {
		return $this->hasMany('App\CjtoMontagem');
	}

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function handles() {
		return $this->hasMany('App\Handle');
	}

}
