<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producttransition extends Model
{
    use HasFactory;
	
						 protected $fillable = [
         'balance_of_business_id', 
		'customer_id',
		'productorder_id',
		'user_id',
		'unirprice',
	'product_id', 'quantityinbase',
		'quantity',
		'amount',	'discountpercentage',	'discount',	'finalamountafterdiscount', 'unitname', 'sellingunit',
'unitcoversion_id','type',
    ];	
	
				 public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }
	

					 public function product()
    {
    	return $this->belongsTo(Product::class);
    }
					 public function productorder()
    {
    	return $this->belongsTo(productorder::class,'productorder_id');
    }

					 public function user()
    {
    	return $this->belongsTo(user::class,'user_id');
    }	
	
				 public function unitcoversion()
    {
    	return $this->belongsTo(unitcoversion::class);
    }	
	
	
	
	
	
	
	
}
