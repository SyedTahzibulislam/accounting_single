<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanknamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banknames', function (Blueprint $table) {
            $table->id();
			$table->foreignId('balance_of_business_id');
			$table->string('name');
			$table->string('address')->nullable();
			$table->double('openingbalance',14,2)->default(0);
			$table->double('currentbalance',14,2)->default(0);
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
        Schema::dropIfExists('banknames');
    }
}
