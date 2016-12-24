<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChecadasCt extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('checadas_ct',function(Blueprint $table){
			$table->increments('idChecadaCt');
			$table->integer('idEmpleadoCt')->unsigned();
			$table->date('fecha');
			$table->time('hora_entrada');
			$table->time('hora_salida');
			$table->decimal('horas_ordinarias',5,2);
			$table->decimal('horas_extra',5,2)->nullable();
			$table->enum('incidencia',['falta justificada','falta injustificada','permiso'])->nullable();
			$table->string('comentarios',250)->nullable();
			$table->integer('idUsuario')->unsigned();

			//referencias llaves foraneas
			$table->foreign('idUsuario')->references('id')->on('users');
			$table->foreign('idEmpleadoCt')->references('idEmpleadoCt')->on('empleados_ct');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('checadas_ct');
	}

}
