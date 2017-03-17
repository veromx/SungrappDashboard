<?php

namespace Sungrapp\Models;

use Illuminate\Database\Eloquent\Model;
use Sungrapp\Models\Supplier;

class Message extends Model
{
    protected $fillable = [
		'supplier_id',
		'message',
	];

	public function supplier(){
		return $this->belongsTo(Supplier::class);
	}

	public function getCreatedAtAttribute($value){
		$value= new \Carbon\Carbon($value);
		$value->setLocale('es_MX.iso88591');
		return $value;
	}
}
