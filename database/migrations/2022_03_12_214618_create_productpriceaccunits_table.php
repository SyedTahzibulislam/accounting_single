<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductpriceaccunitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productpriceaccunits', function (Blueprint $table) {
            $table->id();
	$table->foreignId('product_id');     
	 $table->foreignId('unitcoversion_id');  
	 $table->foreignId('balance_of_business_id');
	$table->foreignId('user_id');
$table->double('unitprice', 12, 2);	 
$table->double('stock', 12, 2)->nullable();	


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productpriceaccunits');
    }
}
