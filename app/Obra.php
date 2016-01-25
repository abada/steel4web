<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model {
	protected $table = 'obras';
	protected $fillable = array(
		'codigo',
		'nome',
		'descricao',
		'cidade',
		'endereco',
		'cep',
		'cliente_id',
		'gerenciadoraid',
		'calculistaid',
		'detalhamentoid',
		'montagemid',
		'status',
		'user_id',
		'locatario_id',
	);
	protected $visible = array(
		'codigo',
		'nome',
		'descricao',
		'cidade',
		'endereco',
		'cep',
		'cliente_id',
		'gerenciadoraid',
		'calculistaid',
		'detalhamentoid',
		'montagemid',
		'status',
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
	public function cjtomontagem() {
		return $this->hasMany('App\CjtoMontagem');
	}

	/**
	 * Get the importacoes for the blog post.
	 */
	public function importacoes() {
		return $this->hasMany('App\Importacao');
	}

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function etapas() {
		return $this->hasMany('App\Etapa');
	}

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function handles() {
		return $this->hasMany('App\Handle');
	}

	/**
	 * Get the Contatos of the Obras
	 * @return Relationship belongsTo
	 */
	public function contatos() {
		return $this->belongsToMany('App\Contato', 'contato_obra');
	}
}