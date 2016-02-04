<?php

namespace App\Models\Access\User\Traits\Relationship;

// use App\Models\Access\User\SocialLogin;

/**
 * Class UserRelationship
 * @package App\Models\Access\User\Traits\Relationship
 */
trait UserRelationship {

	/**
	 * Many-to-Many relations with Role.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles() {
		return $this->belongsToMany(config('access.role'), config('access.assigned_roles_table'), 'user_id', 'role_id');
	}

	/**
	 * Many-to-Many relations with Permission.
	 * ONLY GETS PERMISSIONS ARE NOT ASSOCIATED WITH A ROLE
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function permissions() {
		return $this->belongsToMany(config('access.permission'), config('access.permission_user_table'), 'user_id', 'permission_id');
	}

	/**
	 * @return mixed
	 */
	public function providers() {
		// return $this->hasMany(SocialLogin::class);
	}

	// RELATIONSHIPS

	/**
	 * Get the LOCATÁRIO (company of users) of the model
	 * @return Relationship belongsTo
	 */
	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}

	/**
	 * Get the Image (avatar) of the model
	 * @return Relationship belongsTo
	 */
	public function image() {
		return $this->hasOne('App\Images');
	}

	// REVERSE RELATIONSHIPS...

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function cjtofabr() {
		return $this->hasMany('App\CjtoFabr');
	}

	/**
	 * Get the related Models
	 * @return Relationship hasMany
	 */
	public function cjtomontagens() {
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
	 * Get the obras
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

}