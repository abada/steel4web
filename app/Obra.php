<?php
namespace App;

use App\LocatarioScope;
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
		'status',
		'user_id',
		'locatario_id',
	);
	protected $visible = array(
		'id',
		'codigo',
		'nome',
		'descricao',
		'cidade',
		'endereco',
		'cep',
		'cliente_id',
		'status',
		'user_id',
		'locatario_id',
	);

	protected static function boot() {
		parent::boot();

		static::addGlobalScope(new LocatarioScope);
	}

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
		return $this->belongsTo('App\Models\Access\User\User');
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
	 * Get the importacoes for the blog post.
	 */
	public function lotes() {
		return $this->hasMany('App\Lote');
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
	public function romaneios() {
		return $this->hasMany('App\Romaneio');
	}

	/**
	 * Get the Contatos of the Obras
	 * @return Relationship belongsTo
	 */
	public function contatos() {
		return $this->belongsToMany('App\Contato', 'contato_obra');
	}

	/**
	 * Get the Users of the Obras
	 * @return Relationship belongsTo
	 */
	public function users() {
		return $this->belongsToMany('App\Models\Access\User\User', 'obra_user');
	}
}