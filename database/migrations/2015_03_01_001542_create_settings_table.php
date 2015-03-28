<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
            $table->increments('id');
            $table->string('company', 255);
            $table->string('slogan', 255);
            $table->string('address1', 255);
            $table->string('address2', 255);
            $table->string('city', 255);
            $table->string('state', 2);
            $table->string('postal_code', 10);
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
		Schema::drop('settings');
	}

}
