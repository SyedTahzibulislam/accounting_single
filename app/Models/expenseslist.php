<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expenseslist extends Model
{
    use HasFactory;
	
	
	
protected $fillable = [
   'balance_of_business_id',       
'name',
'parent_id',
'secondparent_id',
'thirdparent_id'
    ];
	
		public function thirdparent()
    {
    	return $this->belongsTo(expenseslist::class, 'thirdparent_id');
    }
	
	
	
	public function secondparent()
    {
    	return $this->belongsTo(expenseslist::class, 'secondparent_id');
    }
	
	
	public function children()
	{
		return $this->hasMany( expenseslist::class, 'parent_id')->with('children');
		
	}
	
	
	 public function parentcat()
    {
        return $this->belongsTo( expenseslist::class, 'parent_id')->with('parentcat');
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
}
