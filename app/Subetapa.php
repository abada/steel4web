<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subetapa extends Model {
	protected $table = 'subetapas';
	protected $fillable = [
		'cod',
		'peso',
		'tiposubetapa_id',
		'observacao',
		'etapa_id',
		'user_id',
		'locatario_id',
	];

	/**
	 * Get the Etapa of the model
	 * @return Relationship belongsTo
	 */
	public function etapa() {
		return $this->belongsTo('App\Etapa');
	}

	/**
	 * Get the TipoSubetapa of the model
	 * @return Relationship belongsTo
	 */
	public function tipo() {
		return $this->belongsTo('App\TipoSubetapa', 'tiposubetapa_id');
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
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function handles() {
		return $this->hasMany('App\Handle');
	}

	/**
	 * Get the importacoes for the blog post.
	 */
	public function importacoes() {
		return $this->hasMany('App\Importacao');
	}

	/**
	 * Get the lotes for the blog post.
	 */
	public function lotes() {
		return $this->hasMany('App\Lote');
	}


}
