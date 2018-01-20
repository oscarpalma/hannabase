<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecadaProyectoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('checadasProyecto',function(Blueprint $table){
			$table->increments('idChecada');
			$table->integer("idCliente")->unsigned();
			$table->integer('idTurno')->unsigned();
			$table->string('idEmpleado',6);
			$table->date('fecha');
			$table->time('hora_entrada');
			$table->time('hora_salida');
			$table->decimal('horas_ordinarias',5,2);
			$table->decimal('horas_extra',5,2)->nullable();
			
			$table->integer('idUsuario')->unsigned();

			//referencias llaves foraneas
			$table->foreign("idCliente")->references('idCliente')->on('clientesProyecto')->onDelete('cascade');
			$table->foreign('idTurno')->references('idTurno')->on('turnosProyecto')->onDelete('cascade');
			$table->foreign('idEmpleado')->references('idEmpleado')->on('empleadosProyecto')->onDelete('cascade');
			$table->foreign('idUsuario')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{	  DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Schema::drop('checadasProyecto');
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
