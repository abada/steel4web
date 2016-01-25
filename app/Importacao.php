<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Importacao extends Model {

	protected $table = 'importacoes';
	protected $fillable = array(
		'descricao',
		'cliente_id',
		'obra_id',
		'etapa_id',
		'subetapa_id',
		'dbf2d',
		'ifc',
		'fbx',
		'ifc_orig',
		'fbx_orig',
		'erro_debug',
		'importacaoNr',
		'observacoes',
		'sentido',
		'user_id',
		'locatario_id',
	);

	/**
	 * Get the Cliente of the model
	 * @return Relationship belongsTo
	 */
	public function cliente() {
		return $this->belongsTo('App\Cliente');
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

	// REVERSE RELATIONSHIPS...

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function handles() {
		return $this->hasMany('App\Handle');
	}

}
