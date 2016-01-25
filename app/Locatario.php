<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locatario extends Model
{
    protected $table = 'locatarios';
	public $timestamps = false;
	protected $fillable = array(
		'razao',
		'fantasia',
		'tipo',
		'documento',
		'inscricao',
		'fone',
		'cidade',
		'endereco',
		'cep',
		'email',
		'status',
		'data'
	);
	protected $visible = array(
		'razao',
		'fantasia',
		'tipo',
		'documento',
		'inscricao',
		'fone',
		'cidade',
		'endereco',
		'cep',
		'email',
		'status',
		'data'
	);
}
