<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Turnos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('turnos',function(Blueprint $table){
			$table->increments('idTurno');
			$table->integer('idCliente')->unsigned();
			$table->time('hora_entrada');
			$table->time('hora_salida');
			$table->decimal('horas_trabajadas',5,2);

			//declarar las referencias de las llaves foraneas
			$table->foreign('idCliente')->references('idCliente')->on('clientes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('turnos');
	}

}
