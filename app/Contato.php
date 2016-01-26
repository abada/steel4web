<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model {

	protected $table = 'contatos';
	protected $fillable = [
		'razao',
		'fantasia',
		'tipo',
		'documento',
		'inscricao',
		'fone',
		'cidade',
		'endereco',
		'cep',
		'responsavel',
		'email',
		'site',
		'crea',
		'cliente_id',
		'user_id',
		'locatario_id',
	];

	/**
	 * Get the Cliente of the model
	 * @return Relationship belongsTo
	 */
	public function cliente() {
		return $this->belongsTo('App\Cliente');
	}

	/**
	 * Get the TipoContato of the model
	 * @return Relationship belongsTo
	 */
	public function tipo() {
		return $this->belongsTo('App\TipoContato');
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

	/**
	 * Get the Obra of the Contato
	 * @return Relationship belongsTo
	 */
	public function obras() {
		return $this->belongsToMany('App\Obra', 'contato_obra');
	}
}
