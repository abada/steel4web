<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locatario extends Model {
	protected $table = 'locatarios';
	public $timestamps = false;
	protected $fillable = array(
		'razao',
		'fantasia',
		'tipo',
		'documento',
		'inscricao',
		'fone',
		'cidade',
		'endereco',
		'cep',
		'email',
		'status',
	);
	protected $visible = array(
		'razao',
		'fantasia',
		'tipo',
		'documento',
		'inscricao',
		'fone',
		'cidade',
		'endereco',
		'cep',
		'email',
		'status',
	);

	// REVERSE RELATIONS...

	/**
	 * Get the related Model
	 * @return Relationship hasMany
	 */
	public function users() {
		return $this->hasMany('App\Models\Access\User\User');
	}

	/**
	 * Get the related Model
	 * @return Relationship hasMany
	 */
	public function cjtofabr() {
		return $this->hasMany('App\CjtoFabr');
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
	public function clientes() {
		return $this->hasMany('App\Cliente');
	}

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
	public function estagios() {
		return $this->hasMany('App\Estagio');
	}

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function etapas() {
		return $this->hasMany('App\Etapa');
	}

	/**
	 * Get the related Model
	 * @return Relationship hasMany
	 */
	public function romaneios() {
		return $this->hasMany('App\Romaneio');
	}

	/**
	 * Get the related Model
	 * @return Relationship hasMany
	 */
	public function motoristas() {
		return $this->hasMany('App\Motorista');
	}

	/**
	 * Get the related Model
	 * @return Relationship hasMany
	 */
	public function transportadoras() {
		return $this->hasMany('App\Transportadora');
	}

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
	 * Get the medicoes
	 */
	public function medicoes() {
		return $this->hasMany('App\Medicao');
	}

	/**
	 * Get the obras for the blog post.
	 */
	public function obras() {
		return $this->hasMany('App\Obra');
	}

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function subetapas() {
		return $this->hasMany('App\Subetapa');
	}

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function lotes() {
		return $this->hasMany('App\Lote');
	}
}