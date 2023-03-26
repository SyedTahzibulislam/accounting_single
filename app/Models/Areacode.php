<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areacode extends Model
{
    use HasFactory;
	
		 protected $fillable = [
        'code',
       'address',
		'softdelete',
		'balance_of_business_id',
	
    ];
	
	
}
