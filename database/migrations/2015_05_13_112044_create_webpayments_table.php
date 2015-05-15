<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebpaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('webpayments', function(Blueprint $table) {

           $table->increments('id');
           $table->integer('user_id')->unsigned();
           $table->string('token',255);
           $table->string('amount');
            $table->boolean('active')->default(false);
           $table->timestamps();
           $table->foreign('user_id')->references('id')->on('users');


        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
        Schema::drop('webpayments');
	}

}
