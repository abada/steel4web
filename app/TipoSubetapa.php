<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class TipoSubetapa extends Model {

	protected $fillable = [
		'descricao',
		'user_id',
		'locatario_id',
	];

	protected $table = 'tipossubetapas';

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
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function subetapas() {
		return $this->hasMany('App\Subetapa');
	}
}
