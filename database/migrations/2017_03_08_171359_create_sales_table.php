<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('package_id')->unsigned()->index('fk_sales_package_idx');
			$table->integer('supplier_id')->unsigned()->index('fk_sales_supplier_idx');
			$table->float('total', 10, 0);
			$table->float('iva', 10, 0)->nullable();
			$table->float('sub_total', 10)->nullable();
			$table->boolean('invoice')->default(0);
			$table->string('status', 45)->nullable()->comment('nuevo, renovacion, cancelado, vencido
');
			$table->smallInteger('amount')->nullable();
			$table->float('unit_price', 10)->nullable();
			$table->string('payment_method', 45)->nullable();
			$table->dateTime('created_at')->nullable();
			$table->dateTime('udpated_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sales');
	}

}
