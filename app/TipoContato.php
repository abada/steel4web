<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContato extends Model {
	protected $table = 'tiposcontatos';
	protected $fillable = ['descricao', 'user_id', 'locatario_id'];

	/**
	 * Get the contatos.
	 */
	public function contatos() {
		return $this->hasMany('App\Contato', 'tipo');
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
