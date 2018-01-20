<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteProyectoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientesProyecto',function(Blueprint $table){
			$table->increments('idCliente');
			$table->string('nombre',45);
			$table->string('direccion',45);
			$table->string('telefono',10);
			$table->string('contacto',45);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{	DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Schema::drop('clientesProyecto');
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
