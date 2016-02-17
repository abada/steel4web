<?php

namespace App;

use App\LocatarioScope;
use App\Lote;
use Illuminate\Database\Eloquent\Model;

class Handle extends Model {

	protected $table = 'handles';

	protected $fillable = [
		'HANDLE',
		'FLG_REC',
		'NUM_COM',
		'DES_COM',
		'LOT_COM',
		'DLO_COM',
		'CLI_COM',
		'IND_COM',
		'DT1_COM',
		'DT2_COM',
		'NUM_DIS',
		'DES_DIS',
		'NOM_DIS',
		'REV_DIS',
		'DAT_DIS',
		'TRA_PEZ',
		'SBA_PEZ',
		'DES_SBA',
		'TIP_PEZ',
		'MAR_PEZ',
		'MBU_PEZ',
		'DES_PEZ',
		'POS_PEZ',
		'NOT_PEZ',
		'ING_PEZ',
		'MAX_LEN',
		'QTA_PEZ',
		'QT1_PEZ',
		'MCL_PEZ',
		'COD_PEZ',
		'COS_PEZ',
		'NOM_PRO',
		'LUN_PRO',
		'LAR_PRO',
		'SPE_PRO',
		'MAT_PRO',
		'TIP_BUL',
		'DIA_BUL',
		'LUN_BUL',
		'PRB_BUL',
		'PUN_LIS',
		'SUN_LIS',
		'PRE_LIS',
		'FLG_DWG',
		'obra_id',
		'lote_id',
		'estagio_id',
		'etapa_id',
		'subtapa_id',
		'GROUP',
		'CATE',
		'importacao_id',
		'medicao_id',
		'subetapa_id',
		'X',
		'Y',
		'Z',
		'A',
		'B',
		'user_id',
		'locatario_id',
	];

	protected static function boot() {
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
	 * Get the LOTE of the model
	 * @return Relationship belongsTo
	 */
	public function lote() {
		return $this->belongsTo('App\Lote');
	}

	/**
	 * Get the LOTE of the model
	 * @return Relationship belongsTo
	 */
	public function romaneio() {
		return $this->belongsTo('App\Romaneio');
	}

	/**
	 * Get the Estagio of the model
	 * @return Relationship belongsTo
	 */
	public function estagio() {
		return $this->belongsTo('App\Estagio');
	}

	/**
	 * Get the Etapa of the model
	 * @return Relationship belongsTo
	 */
	public function etapa() {
		return $this->belongsTo('App\Etapa');
	}

	/**
	 * Get the Subtapa of the model
	 * @return Relationship belongsTo
	 */
	public function subetapa() {
		return $this->belongsTo('App\Subetapa');
	}

	/**
	 * Get the Importacao of the model
	 * @return Relationship belongsTo
	 */
	public function importacao() {
		return $this->belongsTo('App\Importacao');
	}

	/**
	 * Get the Medicao of the model
	 * @return Relationship belongsTo
	 */
	public function medicao() {
		return $this->belongsTo('App\Medicao');
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

	// REVERSE RELATIONS...

	/**
	 * Get the related Model
	 * @return Relationship hasMany
	 */
	public function cjtofabr() {
		return $this->hasMany('App\CjtoFabr');
	}

	/**
	 * Get the related Model
	 * @return Relationship hasMany
	 */
	public function cjtomontagem() {
		return $this->hasMany('App\CjtoMontagem');
	}

}
