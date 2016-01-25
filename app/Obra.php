<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
	protected $table = 'obras';
	public $timestamps = true;
	protected $fillable = array(
		'codigo',
		'nome',
		'descricao',
		'cidade',
		'endereco',
		'cep',
		'cliente_id',
		'gerenciadoraid',
		'calculistaid',
		'detalhamentoid',
		'montagemid',
		'data',
		'status',
		'user_id',
		'locatario_id',
	);
	protected $visible = array(
		'codigo',
		'nome',
		'descricao',
		'cidade',
		'endereco',
		'cep',
		'cliente_id',
		'gerenciadoraid',
		'calculistaid',
		'detalhamentoid',
		'montagemid',
		'data',
		'status',
		'user_id',
		'locatario_id',
	);

}
