<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicetransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicetransitions', function (Blueprint $table) {
            $table->id();
			$table->foreignId('balance_of_business_id');
			 $table->foreignId('serviceorder_id')->nullable();
			 $table->foreignId('servicelistinhospital_id')->nullable();
			 
			  $table->foreignId('user_id');

            $table->double('charge',14,2);	
         	$table->double('unit', 14, 4);	
			
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
        Schema::dropIfExists('servicetransitions');
    }
}
