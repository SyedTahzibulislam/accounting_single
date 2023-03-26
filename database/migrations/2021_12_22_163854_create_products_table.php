<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
			 $table->foreignId('balance_of_business_id');          
			$table->foreignId('productcategory_id');
			$table->foreignId('Productcompany_id')->nullable();
		
			$table->integer('stockunit')->nullable();
			$table->integer('buyingunit')->nullable();
			$table->integer('sellingunit')->nullable();			
			$table->string('name');  
			$table->string('productcode')->nullable();   
			$table->double('stock', 12, 2);
			$table->double('unitprice', 12, 2);
			$table->tinyInteger('softdelete')->default('0');
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
        Schema::dropIfExists('products');
    }
}
