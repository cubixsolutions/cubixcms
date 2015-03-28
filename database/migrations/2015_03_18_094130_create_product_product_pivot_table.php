<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProductPivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('related_products', function(Blueprint $table)
		{
			$table->integer('product_id')->unsigned()->index();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->integer('related_id')->unsigned()->index();
			$table->foreign('related_id')->references('id')->on('products')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('related_products');
	}

}
