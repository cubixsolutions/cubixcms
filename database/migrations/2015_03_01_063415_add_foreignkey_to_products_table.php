<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeyToProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function(Blueprint $table) {

            $table->foreign('category_id')->references('id')->on('product_categories');
            $table->foreign('product_type')->references('id')->on('product_types');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('products', function(Blueprint $table) {

            $table->dropForeign('products_category_id_foreign');
            $table->dropForeign('products_product_type_foreign');

        });
	}

}
