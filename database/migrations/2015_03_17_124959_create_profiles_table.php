<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function(Blueprint $table) {

            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->string('address_1',255);
            $table->string('address_2',255);
            $table->string('city',255);
            $table->string('state',2);
            $table->string('postal_code',10);
            $table->foreign('user_id')->references('id')->on('users');
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
		Schema::drop('profiles');
	}

}
