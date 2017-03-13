<?php

namespace Sungrapp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model{

use SoftDeletes;

public $timestamps = false;

	protected $dates = [
		'deleted_at',
	];

	protected $fillable = [
        'full_name', 'email', 'rfc', 'project_name', 'logo_file_name', 'address_id',
    ];

	// hidden attributes in arrays
    protected $hidden = ['created_at', 'updated_at'];

}
