<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeproviderduetransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomeproviderduetransitions', function (Blueprint $table) {
            $table->id();
			
						$table->foreignId('user_id');
			$table->foreignId('balance_of_business_id');
			
		    $table->foreignId('externalincomeprovider_id');
			
		
			$table->double('amount', 14, 4);
			
			$table->text('comment')->nullable();
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
        Schema::dropIfExists('incomeproviderduetransitions');
    }
}
