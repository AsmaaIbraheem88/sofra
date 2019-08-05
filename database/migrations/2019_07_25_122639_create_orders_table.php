<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('restaurant_id');
			$table->enum('status', array('pending', 'accepted', 'rejected', 'delivered', 'declined'));
			$table->decimal('price');
			$table->decimal('delivery_cost');
			$table->decimal('total_price');
			$table->decimal('commission');
			$table->integer('client_id');
			$table->text('notes')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}