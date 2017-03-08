<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('sale_id')->unsigned()->nullable()->index('fk_invoices_sale_idx');
			$table->string('status_invoice', 45)->nullable();
			$table->string('folio', 45)->nullable();
			$table->string('serie', 45)->nullable();
			$table->string('folio_fiscal', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoices');
	}

}
