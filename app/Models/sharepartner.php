<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sharepartner extends Model
{
    use HasFactory;
				 protected $fillable = [
        'name',
		'balance_of_business_id',
		'mobile',
		'address',
		'softdelete',
		'uttholon',
		'joma',

    ];
}
