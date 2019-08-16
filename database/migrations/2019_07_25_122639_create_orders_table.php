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
			$table->decimal('price')->default(0);
			$table->decimal('delivery_cost')->default(0);
			$table->decimal('total_price')->default(0);
			$table->decimal('commission')->default(0);
			$table->integer('client_id');
			$table->integer('payment_method_id');
			$table->string('address');
			$table->text('notes')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}