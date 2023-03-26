<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhorocerKhadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khorocer_khads', function (Blueprint $table) {
            $table->id();
			$table->foreignId('balance_of_business_id');
			$table->string('name');
				$table->string('path');
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
        Schema::dropIfExists('khorocer_khads');
    }
}
