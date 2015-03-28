<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {

            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->float('order_amount');
            $table->string('order_shipName',255);
            $table->string('order_shipAddress',255);
            $table->string('order_shipAddress2',255);
            $table->string('order_City',255);
            $table->string('order_State',2);
            $table->string('order_Zip',10);
            $table->string('order_Country',255);
            $table->string('order_Phone',20);
            $table->string('order_Fax',20);
            $table->float('order_Shipping');
            $table->float('order_Tax');
            $table->string('order_Email',255);
            $table->boolean('order_Shipped');
            $table->string('order_TrackingNumber',80);

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
		Schema::drop('orders');
	}

}
