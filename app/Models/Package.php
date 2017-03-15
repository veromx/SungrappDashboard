<?php

namespace Sungrapp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model{
    
    use SoftDeletes;

    // store attributes 
	protected $fillable = [
        'name', 
        'active_time', 
        'time_period_type',
        'num_users', 
        'num_customers',
        'email', 
        'cost', 
    ];

    // don't allow to write attributes
    protected $guarded = ['id', 'created_at', 'updated_at']; 

    // hidden attributes in arrays
    protected $hidden = ['created_at', 'updated_at'];
    

}
