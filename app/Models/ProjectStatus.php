<?php

namespace Sungrapp\Models;

use Sungrapp\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectStatus extends Model
{

	protected $table = 'projects_status';

    // store attributes
	protected $fillable = [
        'project_id',
        'status_name'
    ];

    // don't allow to write attributes
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // hidden attributes in arrays
    protected $hidden = ['created_at', 'updated_at'];

	public function project(){
		return $this->belongsTo(Project::class);
	}

}
