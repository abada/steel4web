<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table 		= 'clientes';    
	protected $fillable 	= ['razao', 'fantasia', 'documento', 'inscricao', 'fone', 'endereco', 'cep', 'responsavel', 'email', 'site', 'user_id', 'locatario_id'];

    /**
     * Get the obras for the blog post.
     */
    public function obras()
    {
        return $this->hasMany('App\Obra');
    }

}
