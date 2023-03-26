<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productcompany extends Model
{
    use HasFactory;
	
		 protected $fillable = [
        'name',
'softdelete',
'due',
'openingbalance','balance_of_business_id',
'address',
'mobile',
    ];
	

		public function Product()
    {
        return $this->hasMany(Product::class);
    }

	
}
