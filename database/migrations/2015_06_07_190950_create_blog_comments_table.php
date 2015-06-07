<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_comments', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('blog_id')->unsigned();
            $table->longText('comment');
			$table->timestamps();
            $table->foreign('blog_id')->references('id')->on('blogs');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_comments');
	}

}
