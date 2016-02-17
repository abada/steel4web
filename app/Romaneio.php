<?php

namespace App;

use App\LocatarioScope;
use Illuminate\Database\Eloquent\Model;

class Romaneio extends Model
{
   protected $table = 'romaneios';
	protected $fillable = [
		'codigo',
		'Nfs',
		'data_saida',
		'previsao_chegada',
		'status',
		'observacoes',
		'motorista_id',
		'transportadora_id',
		'subetapa_id',
		'etapa_id',
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
	 * Get the Etapa of the model
	 * @return Relationship belongsTo
	 */
	public function transportadora() {
		return $this->belongsTo('App\Transportadora');
	}

	/**
	 * Get the Subetapa of the model
	 * @return Relationship belongsTo
	 */
	public function motorista() {
		return $this->belongsTo('App\Motorista');
	}

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function handles() {
		return $this->hasMany('App\Handle');
	}
}
