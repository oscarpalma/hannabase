<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Checadas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('checadas',function(Blueprint $table){
			$table->increments('idChecada');
			$table->integer("idCliente")->unsigned();
			$table->integer('idTurno')->unsigned();
			$table->integer('idEmpleado')->unsigned();
			$table->date('fecha');
			$table->time('hora_entrada');
			$table->time('hora_salida');
			$table->decimal('horas_ordinarias',5,2);
			$table->decimal('horas_extra',5,2)->nullable();
			$table->enum('incidencia',['falta justificada','falta injustificada','permiso'])->nullable();
			$table->string('comentarios',200)->nullable();
			$table->integer('idUsuario')->unsigned();

			//referencias llaves foraneas
			$table->foreign("idCliente")->references('idCliente')->on('clientes');
			$table->foreign('idTurno')->references('idTurno')->on('turnos');
			$table->foreign('idEmpleado')->references('idEmpleado')->on('empleados');
			$table->foreign('idUsuario')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('checadas');
	}

}
