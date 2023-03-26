<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductcompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productcompanies', function (Blueprint $table) {
            $table->id();
			$table->foreignId('balance_of_business_id');
				$table->string('name');
			$table->string('address')->nullable();
			$table->string('mobile')->nullable();
			$table->double('due')->default('0');
			$table->double('openingbalance')->default('0');
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
        Schema::dropIfExists('productcompanies');
    }
}
