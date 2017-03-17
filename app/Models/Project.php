<?php

namespace Sungrapp\Models;

use Sungrapp\Models\Supplier;
use Sungrapp\Models\ProjectStatus;
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

	protected $dates = [
		'deleted_at',
	];

	public function supplier(){
		return $this->belongsTo(Supplier::class);
	}

	public function status(){
		return $this->hasOne(ProjectStatus::class);
	}

}
