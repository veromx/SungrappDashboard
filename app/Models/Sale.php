<?php

namespace Sungrapp\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    // store attributes 
	protected $fillable = [
        'package_id', 
        'supplier_id', 
        'total', 
        'iva', 
        'sub_total',
        'status',
        'amount', 
        'unit_price', 
        'peyment_method'
    ];

    // don't allow to write attributes
    protected $guarded = ['id', 'created_at', 'updated_at']; 

    // hidden attributes in arrays
    protected $hidden = ['created_at', 'updated_at'];

    /*
    * Relationships
    */

	/*
	 * belongsTo Relationship :: get the supplier and its purschase
	 */
	public function supplier(){
		return $this->belognsTo('Sungrapp\Models\Supplier', 'id', 'supplier_id');
	}

    /*
	 * HasOne Relationship :: the package of one sale 
	 */
	public function package(){
		return $this->HasOne('Sungrapp\Models\Package', 'id', 'package_id');
	}

}
