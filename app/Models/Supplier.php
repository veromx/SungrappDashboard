<?php

namespace Sungrapp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sungrapp\Models\Message;
use Sungrapp\Models\User;

class Supplier extends Model{

use SoftDeletes;

public $timestamps = false;

	protected $dates = [
		'deleted_at',
	];

	// store attributes
	protected $fillable = [
        'full_name',
		'email',
		'rfc',
		'logo_file_name',
		'phone_number',
		'potential_supplier'
    ];

	// hidden attributes in arrays
    protected $hidden = ['created_at', 'updated_at'];


	/*
    * Scopes
    */

	/*
	 * scope non suppliers
	 */
    public function scopePotentialSuppliers($query){
        $query->where('potential_supplier', '=', 1);
    }

	/*
	 * scope suppliers
	 */
    public function scopeOnlySuppliers($query){
        $query->where('potential_supplier', '=', 0);
    }

    /*
    * Relationships
    */

	/*
	 * HasMany Relationship :: get all the messages of a supplier
	 */
	public function messages(){
		return $this->hasMany(Message::class);
	}

	// also for users
	public function users(){
		return $this->hasMany(User::class);
	}

}
