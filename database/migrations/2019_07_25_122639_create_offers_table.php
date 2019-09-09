<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('content_ar');
			$table->string('title_en');
			$table->text('content_en');
			$table->string('title_ar');
			$table->integer('restaurant_id');
			$table->datetime('start_date');
			$table->datetime('end_date');
			$table->string('image');
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}