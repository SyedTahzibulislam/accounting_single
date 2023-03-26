<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankname extends Model
{
    use HasFactory;
					 protected $fillable = [
        'name',
		'address',
		'openingbalance',
		'softdelete',
	'currentbalance',
	
	'balance_of_business_id',	

    ];
	
	
			public function Bankchalan()
    {
        return $this->hasMany(Bankchalan::class);
    }
	
	
	
	
}
