<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estagio extends Model {
	protected $table = 'estagios';

	protected $fillable = [
		'descricao',
		'ordem',
		'tipoestagio_id',
		'user_id',
		'locatario_id',
	];

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

	/**
	 * Get the TipoEstagio of the model
	 * @return Relationship belongsTo
	 */
	public function tipo() {
		return $this->belongsTo('App\TipoEstagio', 'tipoestagio_id');
	}

	// REVERSE RELATIONSHIPS...

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function cronogramas() {
		return $this->hasMany('App\Cronograma');
	}

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function handles() {
		return $this->hasMany('App\Handle');
	}
}
