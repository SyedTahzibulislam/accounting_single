<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashtransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashtransitions', function (Blueprint $table) {
            $table->id();
			$table->foreignId('balance_of_business_id');
			$table->foreignId('Bankname_id')->nullable();
			$table->foreignId('productcompany_id')->nullable();
			$table->foreignId('customer_id')->nullable();
			$table->foreignId('User_id');
			$table->foreignId('productcompanyorder_id')->nullable();
			$table->foreignId('productorder_id')->nullable();
			$table->foreignId('sharepartner_id')->nullable();
			$table->foreignId('Taka_uttolon_transition_id')->nullable();
			$table->foreignId('bankchalan_id')->nullable();
			$table->foreignId('dhar_shod_othoba_advance_er_mal_buje_pawa_id')->nullable();
			$table->foreignId('khoroch_transition_id')->nullable();
			$table->foreignId('incomeproviderduetransition_id')->nullable();
			$table->foreignId('externalincometransition_id')->nullable();
			
			
			$table->foreignId('externalcost_id')->nullable();
			$table->foreignId('employeesalarytransaction_id')->nullable();
			$table->foreignId('agenttransaction_id')->nullable();
					$table->tinyInteger('type')->default('1');  // 1-> deposit 2->withdrawl
			
				$table->tinyInteger('transtype');   // 1->externalcost 2->khorchtransition
				
				// 3-> supplier er due payement  // 4-> employye salary // 5-> Taka_uttolon_transition
			// 6- banktransition // 7-> product sell // 8-> Customer Due Trans // 9- buy from company
			// 10- due payment to company 11->agentcommission // 12-  externalincome transition //13-?externalincomeprovider due transition 13
			$table->double('amount');
			$table->double('deposit')->default(0);
			$table->double('withdrwal')->default(0);
			$table->text('description')->nullable();
			
			
			
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
        Schema::dropIfExists('cashtransitions');
    }
}
