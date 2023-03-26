<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productcompanytransition extends Model
{
    use HasFactory;
	
		 protected $fillable = [
          'balance_of_business_id',
		'productcompany_id',
		'productcompanyorder_id',
		'user_id',
		'unirprice',
	'product_id',
		'quantity',
		'amount',
'unitname',
'buyingunit',
'discountpercentage',
'discount',	
'finalamountafterdiscount',	
'unitcoversion_id',  

    ];	
	
				 public function productcompany()
    {
    	return $this->belongsTo(productcompany::class);
    }
	

					 public function product()
    {
    	return $this->belongsTo(product::class);
    }
					 public function productcompanyorder()
    {
    	return $this->belongsTo(productcompanyorder::class,'productorder_id');
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
