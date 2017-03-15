<?php

namespace Sungrapp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    // store attributes 
	protected $fillable = [
        'name', 
        'supplier_id'
    ];

    // don't allow to write attributes
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at']; 

    // hidden attributes in arrays
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    
}
