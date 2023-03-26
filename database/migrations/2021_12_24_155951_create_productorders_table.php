<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productorders', function (Blueprint $table) {
            $table->id();
			$table->foreignId('customer_id');
			$table->foreignId('balance_of_business_id');
			$table->foreignId('user_id');
			$table->integer('serialno')->nullable();
			$table->double('amount')->default(0);
			$table->double('discount')->default(0);
			$table->double('amountafterdiscount')->default(0);
			$table->string('comment')->nullable();
			$table->double('debit')->default(0);
			$table->double('credit')->default(0);
			$table->double('balance')->default(0);
			$table->tinyInteger('type')->default('1');  // 1-product bikri 2- due payment 3-product ferot 4-product ferot babod customer k  money back deya   10- reverse entry  5-delete entry   11-reverse due enry 12-deleted due entry
            $table->timestamps();                       // 13- reverse sell money back 14// deleted sell money back  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productorders');
    }
}
