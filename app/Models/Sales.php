<?php

namespace Sungrapp\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    // don't allow to write attributes
    protected $guarded = ['id', 'created_at', 'updated_at']; 

    // hidden attributes in arrays
    protected $hidden = ['created_at', 'updated_at'];
}
