<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reservations', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreignId('shop_id')->references('id')->on('shops')->onDelete('cascade');
			$table->date('visit_date');
			$table->time('visit_time');
			$table->integer('number_of_people');
			$table->string('status')->default('pending');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('reservations');
	}
};
