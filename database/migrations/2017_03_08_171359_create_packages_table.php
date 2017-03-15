<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('packages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 45)->nullable();
			$table->string('time_period_type', 45)->nullable();
			$table->string('active_time', 45)->nullable();
			$table->integer('num_users', 10);
			$table->integer('num_customers', 10);
			$table->boolean('email')->nullable();
			$table->float('cost', 10, 0)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('packages');
	}

}
