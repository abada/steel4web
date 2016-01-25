<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEstagio extends Model {

	protected $table = 'tiposestagios';
	protected $fillable = [
		'descricao',
		'estagio_id',
		'user_id',
		'locatario_id',
	];

	/**
	 * Get the User (owner) of the model
	 * @return Relationship belongsTo
	 */
	public function estagio() {
		return $this->belongsTo('App\Estagio');
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