<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_customers', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'fk_users_customers_customer')->references('id')->on('suppliers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_users_customers_user')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_customers', function(Blueprint $table)
		{
			$table->dropForeign('fk_users_customers_customer');
			$table->dropForeign('fk_users_customers_user');
		});
	}

}
