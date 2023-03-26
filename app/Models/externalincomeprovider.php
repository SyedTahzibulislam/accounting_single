<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class externalincomeprovider extends Model
{
    use HasFactory;
	
	
				 protected $fillable = [
        'name','balance_of_business_id',
'softdelete',
'address',
'mobile',
'ownererkachebaki',
    ];
	
	
	
	
	
	
	
	
}
