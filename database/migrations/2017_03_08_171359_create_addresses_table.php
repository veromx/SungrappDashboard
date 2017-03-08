<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('street', 100);
			$table->string('outdoor_number', 10);
			$table->string('indoor_number', 10)->nullable();
			$table->string('neighborhood', 60)->nullable();
			$table->string('city', 60)->nullable();
			$table->string('state', 45)->nullable();
			$table->string('country', 45)->nullable();
			$table->string('zip_code', 5);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('addresses');
	}

}
