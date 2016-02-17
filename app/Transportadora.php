<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Transportadora extends Model
{
     protected $table = 'transportadoras';
	protected $fillable = [
		'nome',
		'fone1',
		'fone2',
		'contato1',
		'contato2',
		'email',
		'observacoes',
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
	 * Get the related Model
	 * @return Relationship hasMany
	 */
	public function romaneios() {
		return $this->hasMany('App\Romaneio');
	}
}
