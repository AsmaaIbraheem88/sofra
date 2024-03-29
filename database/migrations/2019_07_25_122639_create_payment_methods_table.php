<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentMethodsTable extends Migration {

	public function up()
	{
		Schema::create('payment_methods', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('type_ar');
			$table->string('type_en');
		});
	}

	public function down()
	{
		Schema::drop('payment_methods');
	}
}