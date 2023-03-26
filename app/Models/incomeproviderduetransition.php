<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class incomeproviderduetransition extends Model
{
    use HasFactory;
	
	
	
							 protected $fillable = [
        
	'externalincomeprovider_id',
	'user_id','comment',

		'balance_of_business_id',

	     
		 'amount',
		

    ];
	
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	

	
					 public function externalincomeprovider()
    {
    	return $this->belongsTo(externalincomeprovider::class);
    }

	
		public function User()
    {
    	return $this->belongsTo(User::class);
    }
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
