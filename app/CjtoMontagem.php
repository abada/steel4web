<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CjtoMontagem extends Model {
	protected $table = 'cjtomontagem';

	protected $fillable = ['lote_id', 'obra_id', 'etapa_id', 'medicao_id', 'handle_id', 'dataprev_montagem', 'datareal_montagem', 'dataprev_entrega', 'datareal_entrega', 'montagem', 'entrega', 'user_id', 'locatario_id'];

	/**
	 * Get the LOTE of the model
	 * @return Relationship belongsTo
	 */
	public function lote() {
		return $this->belongsTo('App\Lote');
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
	 * Get the Medicao of the model
	 * @return Relationship belongsTo
	 */
	public function medicao() {
		return $this->belongsTo('App\Medicao');
	}

	/**
	 * Get the Handle of the model
	 * @return Relationship belongsTo
	 */
	public function handle() {
		return $this->belongsTo('App\Handle');
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
