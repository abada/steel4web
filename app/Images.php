<?php

namespace App;

use App\LocatarioScope;
use Illuminate\Database\Eloquent\Model;

class images extends Model
{
	protected $table = 'user_image';
	public $timestamps = true;
	protected $fillable = [
		'user_id',
		'image'
	];

	public function user() {
		return $this->belongsTo('App\Model\Access\User\User');
	}
}
