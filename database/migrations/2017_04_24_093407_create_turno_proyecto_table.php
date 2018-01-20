<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnoProyectoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('turnosProyecto',function(Blueprint $table){
			$table->increments('idTurno');
			$table->integer('idCliente')->unsigned();
			$table->time('hora_entrada');
			$table->time('hora_salida');
			$table->decimal('horas_trabajadas',5,2);

			//declarar las referencias de las llaves foraneas
			$table->foreign('idCliente')->references('idCliente')->on('clientesProyecto')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{	DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Schema::drop('turnosProyecto');
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
