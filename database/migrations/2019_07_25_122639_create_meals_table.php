<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMealsTable extends Migration {

	public function up()
	{
		Schema::create('meals', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name_ar');
			$table->string('name_en');
			$table->string('image')->nullable();
			$table->decimal('price');
			$table->decimal('discount_price');
			$table->string('processing_time');
			$table->text('description_ar');
			$table->text('description_en');
			$table->integer('restaurant_id');
			$table->enum('disabled', array('disable', 'enable'))->default('enable');
		});
	}

	public function down()
	{
		Schema::drop('meals');
	}
}