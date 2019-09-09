<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {

			$table->increments('id');
			$table->string('sitename_ar');
			$table->string('sitename_en');
			$table->string('logo')->nullable();
			$table->string('icon')->nullable();
			$table->string('email')->nullable();
			$table->string('main_lang')->default('ar');
			$table->longtext('description')->nullable();
			$table->longtext('keywords')->nullable();
			$table->enum('status', ['open', 'close'])->default('open');
			$table->longtext('message_maintenance')->nullable();
			$table->decimal('commission');
			$table->decimal('max_credit'); // to compare  payments  to restaurant
			$table->text('commission_msg1');
			$table->text('commission_msg2');
			// $table->string('facebook');
            // $table->string('twitter');
            // $table->string('instagram');
			$table->timestamps();
			
		});
		
	}

	public function down()
	{
		Schema::drop('settings');
	}
}