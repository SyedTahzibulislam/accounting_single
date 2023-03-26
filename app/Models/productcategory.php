<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productcategory extends Model
{
    use HasFactory;
	
			 protected $fillable = [
        'name',
'softdelete','balance_of_business_id',
    ];
	
	
		public function Product()
    {
        return $this->hasMany(Product::class);
    }
	
	
	
}
