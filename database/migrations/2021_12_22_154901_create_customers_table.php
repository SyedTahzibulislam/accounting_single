<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
			$table->foreignId('Areacode_id')->nullable();
			$table->foreignId('balance_of_business_id');
			$table->string('name');
			$table->string('customercode')->nullable();
			$table->string('mobile')->nullable();
			$table->string('address')->nullable();
			$table->double('duelimit')->default(0);
			$table->double('openingbalance')->default(0);
			$table->double('presentduebalance')->default(0);
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
        Schema::dropIfExists('customers');
    }
}
