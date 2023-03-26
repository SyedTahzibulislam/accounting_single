<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseslistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenseslists', function (Blueprint $table) {
            $table->id();
				$table->foreignId('balance_of_business_id');
			  $table->string('name');
				$table->foreignId('parent_id')->nullable(); 
					$table->foreignId('secondparent_id')->nullable(); 
						$table->foreignId('thirdparent_id')->nullable(); 
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
        Schema::dropIfExists('expenseslists');
    }
}
