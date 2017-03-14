<?php

namespace Sungrapp\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    // don't allow to write attributes
    protected $guarded = ['id', 'created_at', 'updated_at']; 

    // hidden attributes in arrays
    protected $hidden = ['created_at', 'updated_at'];

    /*
    * Relationships
    */

	/*
	 * belongsTo Relationship :: ge the supplier and its purschase
	 */
	public function supplier(){
		return $this->belognsTo('Sungrapp\Models\Supplier', 'id', 'supplier_id');
	}

}
