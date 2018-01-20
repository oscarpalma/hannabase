<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTransaccionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transacciones', function(Blueprint $table)
		{
			$table->integer('codigo')->after('factura');
			$table->string('subcategoria',100)->after('factura');
			$table->string('categoria',100)->after('factura');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('transacciones', function(Blueprint $table)
		{
			$table->dropColumn('codigo');
			$table->dropColumn('categoria');
			$table->dropColumn('subcategoria');
		});
	}

}
