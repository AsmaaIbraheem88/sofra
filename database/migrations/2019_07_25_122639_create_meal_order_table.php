<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMealOrderTable extends Migration {

	public function up()
	{
		Schema::create('meal_order', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('order_id');
			$table->integer('meal_id');
			$table->integer('quantity');
			$table->decimal('price');
			$table->text('special_order')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('meal_order');
	}
}