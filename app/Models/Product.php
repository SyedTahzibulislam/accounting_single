<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
				 protected $fillable = [
        'name',
		'stock',
		'buyingunit',
		'sellingunit',
		'stockunit',
		'unitprice',
		'productcategory_id',
		'softdelete',
		'Productcompany_id',
		'productcode',
	'balance_of_business_id',
	
		

    ];
	
		 public function productcategory()
    {
    	return $this->belongsTo(productcategory::class);
    }
	
			 public function Productcompany()
    {
    	return $this->belongsTo(Productcompany::class);
    }
	
			public function productpriceaccunit()
    {
        return $this->hasMany(productpriceaccunit::class);
    }
	
	
	
}
