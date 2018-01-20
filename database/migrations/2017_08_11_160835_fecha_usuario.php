<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FechaUsuario extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
		public function up()
	{
		Schema::table('empleados_ct', function(Blueprint $table)
		{
			$table->date('fecha_ingreso')->after('no_cuenta');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('empleados_ct', function(Blueprint $table)
		{
			$table->dropColumn('fecha_ingreso');
		});
	
	}//


}
