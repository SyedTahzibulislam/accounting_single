<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productorder extends Model
{
    use HasFactory;
	
						 protected $fillable = [
          
		'customer_id',
		'user_id',
		'balance_of_business_id',
		'amount',
	'serialno',
		'discount',
		'amountafterdiscount',	'comment',	'debit',	'credit', 'balance','type',

    ];
					 public function user()
    {
    	return $this->belongsTo(user::class);
    }
	
				 public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }

			public function producttransition()
    {
        return $this->hasMany(producttransition::class);
    }
	
	
}
