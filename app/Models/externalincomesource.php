<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class externalincomesource extends Model
{
    use HasFactory;
	
	
	
				 protected $fillable = [
        'name','balance_of_business_id','path',
'softdelete',
'parent_id',
'secondparent_id',
'thirdparent_id'
    ];
	
	
			public function thirdparent()
    {
    	return $this->belongsTo(khoroch_transition::class, 'thirdparent_id');
    }
	
	
	
	public function secondparent()
    {
    	return $this->belongsTo(khoroch_transition::class, 'secondparent_id');
    }
	
	
	public function children()
	{
		return $this->hasMany( khoroch_transition::class, 'parent_id')->with('children');
		
	}
	
	
	 public function parentcat()
    {
        return $this->belongsTo( khoroch_transition::class, 'parent_id')->with('parentcat');
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
