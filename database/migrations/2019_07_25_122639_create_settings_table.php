<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('about_msg');
			$table->decimal('commission');
			$table->text('commission_msg1');
			$table->text('commission_msg2');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}