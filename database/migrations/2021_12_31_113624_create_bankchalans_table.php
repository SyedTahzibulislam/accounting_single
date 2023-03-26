<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankchalansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankchalans', function (Blueprint $table) {
            $table->id();
			
			
			$table->foreignId('balance_of_business_id');
			$table->foreignId('Bankname_id');
			$table->foreignId('productcompany_id')->nullable();
			$table->foreignId('customer_id')->nullable();
			$table->foreignId('User_id');
			$table->foreignId('productcompanyorder_id')->nullable();
			$table->foreignId('productorder_id')->nullable();
			$table->foreignId('sharepartner_id')->nullable();
			$table->foreignId('Taka_uttolon_transition_id')->nullable();
			$table->double('amount');
			$table->text('description')->nullable();
			$table->double('debit')->default(0);
			$table->double('credit')->default(0);
			$table->date('transdate');
			$table->tinyInteger('type')->default('0');  // 0->joma  1->uttolon 
           $table->tinyInteger('whom')->default('0');  // 0 by ownerhimself  

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
        Schema::dropIfExists('bankchalans');
    }
}
