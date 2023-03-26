<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalincomesourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('externalincomesources', function (Blueprint $table) {
            $table->id();
			$table->string('name');
				$table->string('path');
				
			$table->foreignId('balance_of_business_id')->nullable(); 
			$table->foreignId('parent_id')->nullable(); 
					$table->foreignId('secondparent_id')->nullable(); 
						$table->foreignId('thirdparent_id')->nullable(); 
			
			
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
        Schema::dropIfExists('externalincomesources');
    }
}
