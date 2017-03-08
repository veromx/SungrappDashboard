<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSuppliersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('suppliers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('full_name', 45);
			$table->string('rfc', 13)->nullable();
			$table->string('email', 45)->nullable();
			$table->string('project_name', 45)->nullable();
			$table->string('logo_file_name', 45)->nullable();
			$table->integer('address_id')->unsigned()->nullable()->index('fk_customers_address_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('suppliers');
	}

}
