<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->integer('district_id');
			$table->string('password');
			$table->text('address');
			$table->string('profile_image');
			$table->string('pin_code')->nullable();
			$table->string('api_token', 60)->unique()->nullable();
			$table->enum('is_active', array('active', 'inactive'))->default('active');
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}