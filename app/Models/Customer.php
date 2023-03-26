<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
	
	 protected $fillable = [
        'Areacode_id',
       'name',
		'customercode',
		'mobile',
		'address',
		'duelimit',
		'openingbalance',
		'presentduebalance',
		'softdelete',
		'balance_of_business_id',
		
	
    ];

	  public function Areacode()
    {
        return $this->belongsTo(Areacode::class);
    }
	
}
