<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
	protected $table = 'clientes';
	protected $fillable = ['razao', 'fantasia', 'documento', 'inscricao', 'fone', 'endereco', 'cep', 'responsavel', 'email', 'site', 'user_id', 'locatario_id'];

	/**
	 * Get the obras for the blog post.
	 */
	public function obras() {
		return $this->hasMany('App\Obra');
	}

	/**
	 * Get the contatos for the blog post.
	 */
	public function contatos() {
		return $this->hasMany('App\Contato');
	}

	/**
	 * Get the importacoes for the blog post.
	 */
	public function importacoes() {
		return $this->hasMany('App\Importacao');
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
