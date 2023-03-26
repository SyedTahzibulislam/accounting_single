<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Bankchalan extends Model
{
    use HasFactory;
	
						 protected $fillable = [
        'Bankname_id',
		'balance_of_business_id',
		'amount',
		'description',
		'debit',
		'credit',
	'sharepartner_id',
	'Productcompany_id','customer_id','transdate','type','whom','User_id',
	'productcompanyorder_id',	
	'productorder_id',
	'Taka_uttolon_transition_id',

    ];
	
	
						 public function productcompanyorder()
    {
    	return $this->belongsTo(productcompanyorder::class);
    }

	
						 public function productorder()
    {
    	return $this->belongsTo(productorder::class);
    }

	
						 public function Taka_uttolon_transition()
    {
    	return $this->belongsTo(Taka_uttolon_transition::class);
    }	
	
	
						 public function Bankname()
    {
    	return $this->belongsTo(Bankname::class);
    }
	
							 public function user()
    {
    	return $this->belongsTo(User::class);
    }
		
						 public function Customer()
    {
    	return $this->belongsTo(Customer::class);
    }
	
		
						 public function Productcompany()
    {
    	return $this->belongsTo(Productcompany::class);
    }
	
							 public function sharepartner()
    {
    	return $this->belongsTo(sharepartner::class);
    }
	
	
	
		public function setTransactionDateAttribute($value)
{
    $this->attributes['transdate'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
	    
}

	public function getTransactionDateAttribute($value)
{
    return Carbon::createFromFormat('Y-m-d', $value)->format('m/d/Y');
	   
}
	
}
