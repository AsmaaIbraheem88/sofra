<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('content')->nullable();
			$table->integer('client_id');
			$table->integer('restaurant_id');
			$table->integer('rate');
		});
	}

	public function down()
	{
		Schema::drop('comments');
	}
}