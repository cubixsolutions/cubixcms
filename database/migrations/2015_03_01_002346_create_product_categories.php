<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_categories', function(Blueprint $table) {
            $table->increments('id');
            $table->string('image', 255);
            $table->string('category', 255)->unique();
            $table->string('slug', 255)->unique();
            $table->text('description');
            $table->boolean('active')->default('1');;
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
		Schema::drop('product_categories');
	}

}
