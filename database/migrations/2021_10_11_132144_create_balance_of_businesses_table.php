<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceOfBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_of_businesses', function (Blueprint $table) {
            $table->id();
			$table->string('shopname');
			$table->string('mobile')->nullable();
			$table->string('address')->nullable();
			$table->double('openingbalance', 14,4)->default(0);
			$table->double('balance', 14,4)->default(0);
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
        Schema::dropIfExists('balance_of_businesses');
    }
}
