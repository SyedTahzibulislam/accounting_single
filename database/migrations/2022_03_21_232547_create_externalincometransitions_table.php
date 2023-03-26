<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalincometransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('externalincometransitions', function (Blueprint $table) {
            $table->id();
			
			
			$table->foreignId('user_id');
			$table->foreignId('balance_of_business_id');
			$table->foreignId('externalincomesource_id');
		    $table->foreignId('externalincomeprovider_id');
			
		
			$table->double('amount', 14, 4);
			$table->double('due', 14, 4)->default(0);
	
			
			
			
			
			
			
			
			
			
			
			
			
			
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
        Schema::dropIfExists('externalincometransitions');
    }
}
