<?php

namespace Sungrapp\Models;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    public function scopeUserType($query){
		return $query->where('type','user_type');
	}
}
