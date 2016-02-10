<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model {

	protected $table = 'lotes';

	protected $fillable = ['descricao', 'obra_id', 'etapa_id', 'subetapa_id', 'producao', 'user_id', 'locatario_id'];

	// this is a recommended way to declare event handlers
	protected static function boot() {
		parent::boot();

		static::deleting(function ($lote) {
			// before delete() method call this
			$lote->cjtofabr()->delete();
			// do the rest of the cleanup...
		});
	}

	/**
	 * Get the Obra of the model
	 * @return Relationship belongsTo
	 */
	public function obra() {
		return $this->belongsTo('App\Obra');
	}

	/**
	 * Get the Etapa of the model
	 * @return Relationship belongsTo
	 */
	public function etapa() {
		return $this->belongsTo('App\Etapa');
	}

	/**
	 * Get the Subetapa of the model
	 * @return Relationship belongsTo
	 */
	public function subetapa() {
		return $this->belongsTo('App\Subetapa');
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

	// REVERSE RELATIONS...

	/**
	 * Get the related Model
	 * @return Relationship hasMany
	 */
	public function cronogramas() {
		return $this->hasMany('App\Cronograma');
	}


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
