<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fila extends Model
{
    protected $table = 'fila';
	protected $fillable = array(
		'descricao',
		'arquivo',
		'convertido',
		'importacao_id',
		'locatario_id',
	);
	public $timestamps = false;

	/**
	 * Get the Importacao of the model
	 * @return Relationship belongsTo
	 */
	public function importacao() {
		return $this->belongsTo('App\Importacao');
	}

	/**
	 * Get the LOCATÁRIO (company of users) of the model
	 * @return Relationship belongsTo
	 */
	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}
}
