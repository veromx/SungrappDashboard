<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCfeRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cfe_rates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('description', 45);
			$table->float('basic_precio', 10, 0)->nullable();
			$table->integer('basic_limit_kwh')->nullable();
			$table->float('inter_price', 10, 0)->nullable();
			$table->integer('interlimit_kwh')->nullable();
			$table->float('excess_price', 10, 0)->nullable();
			$table->integer('excesslimit_kwh')->nullable();
			$table->boolean('dac')->default(0);
			$table->boolean('enabled')->default(1);
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
		Schema::drop('cfe_rates');
	}

}
