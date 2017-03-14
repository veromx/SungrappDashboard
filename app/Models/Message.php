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
}
