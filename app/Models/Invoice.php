<?php

namespace Sungrapp\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    // don't allow to write attributes
    protected $guarded = ['id', 'created_at', 'updated_at']; 
}
