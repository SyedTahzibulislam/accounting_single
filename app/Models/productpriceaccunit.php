<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productpriceaccunit extends Model
{
    use HasFactory;
	
	
					 protected $fillable = [
        'product_id',
		'unitcoversion_id',
		'unitprice',
		'balance_of_business_id',
		'user_id','stock',
		
		

    ];
	
		 public function product()
    {
    	return $this->belongsTo(product::class);
    }
	
			 public function unitcoversion()
    {
    	return $this->belongsTo(unitcoversion::class);
    }
	
	
	
	
			 public function balance_of_business()
    {
    	return $this->belongsTo(balance_of_business::class);
    }	
	
	
	
	
}
