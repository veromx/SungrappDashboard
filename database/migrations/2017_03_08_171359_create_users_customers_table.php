<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_customers', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->index('fk_users_customers_user_idx');
			$table->integer('customer_id')->unsigned()->index('fk_users_customers_customer_idx');
			$table->primary(['user_id','customer_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_customers');
	}

}
