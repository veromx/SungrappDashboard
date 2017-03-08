<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sales', function(Blueprint $table)
		{
			$table->foreign('package_id', 'fk_sales_package')->references('id')->on('packages')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('supplier_id', 'fk_sales_supplier')->references('id')->on('suppliers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sales', function(Blueprint $table)
		{
			$table->dropForeign('fk_sales_package');
			$table->dropForeign('fk_sales_supplier');
		});
	}

}
