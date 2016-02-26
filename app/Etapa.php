<?php

namespace App;

use App\LocatarioScope;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model {
	protected $table = 'etapas';
	public $timestamps = true;
	protected $fillable = [
		'codigo',
		'peso',
		'observacao',
		'obra_id',
		'user_id',
		'locatario_id',
	];
	protected $visible = [
		'id',
		'codigo',
		'peso',
		'observacao',
		'obra_id',
		'user_id',
		'locatario_id',
	];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

	/**
	 * Get the Obra of the model
	 * @return Relationship belongsTo
	 */
	public function obra() {
		return $this->belongsTo('App\Obra');
	}

		/**
	 * Get the importacoes for the blog post.
	 */
	public function lotes() {
		return $this->hasMany('App\Lote');
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
	public function medicoes() {
		return $this->hasMany('App\Medicao');
	}

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function subetapas() {
		return $this->hasMany('App\Subetapa');
	}

	/**
	 * Get the Users of the Obras
	 * @return Relationship belongsTo
	 */
	public function romaneios() {
		return $this->belongsToMany('App\Romaneio', 'romaneio_etapa');
	}

}
