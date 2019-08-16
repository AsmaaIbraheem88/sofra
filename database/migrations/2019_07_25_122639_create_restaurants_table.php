<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->integer('district_id');
			$table->decimal('minimum_charge');
			$table->decimal('delivery_cost');
			$table->string('whatsapp_link');
			$table->string('image');
			$table->enum('status', array('open', 'close'))->default('open');
			$table->string('password');
			$table->string('pin_code')->nullable();
			$table->string('api_token', 60)->unique()->nullable();
			$table->boolean('is_active')->default(1);
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}