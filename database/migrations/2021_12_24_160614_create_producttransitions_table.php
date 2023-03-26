<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducttransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producttransitions', function (Blueprint $table) {
            $table->id();
			$table->foreignId('customer_id');
$table->foreignId('balance_of_business_id');
			$table->foreignId('product_id');   
			$table->foreignId('productorder_id'); 
	$table->foreignId('unitcoversion_id')->nullable();			
			$table->string('unitname');
			$table->tinyInteger('type')->default('1');  // 1- bikroy  3- product ferot
			$table->double('sellingunit');	
				
		
			
			$table->foreignId('user_id');
			$table->double('unirprice');
			$table->double('quantity');
			$table->double('quantityinbase');
			$table->double('amount');
			$table->double('discountpercentage')->default(0);
			$table->double('discount')->default(0);
			$table->double('finalamountafterdiscount');
		
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
        Schema::dropIfExists('producttransitions');
    }
}
