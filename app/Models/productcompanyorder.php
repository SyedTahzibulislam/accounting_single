<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productcompanyorder extends Model
{
    use HasFactory;
	
							 protected $fillable = [
          
		'productcompany_id',
		'user_id',
		'balance_of_business_id',
		'amount',
	'serialno',
		'comment',	'debit',	'credit', 'balance','type', 'discount', 'amountafterdiscount',

    ];
					 public function user()
    {
    	return $this->belongsTo(user::class);
    }
	
				 public function productcompany()
    {
    	return $this->belongsTo(Productcompany::class);
    }

			public function productcompanytransition()
    {
        return $this->hasMany(productcompanytransition::class);
    }
	
	
	
	
	
	
	
	
}
