<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title_ar');
			$table->text('content_ar');
			$table->string('title_en');
			$table->text('content_en');
			$table->enum('action', array('requested', 'accepted', 'pending', 'rejected', 'deliverd'));
			$table->integer('notificationable_id');
			$table->string('notificationable_type');
			$table->integer('order_id');
			$table->boolean('is_read')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}