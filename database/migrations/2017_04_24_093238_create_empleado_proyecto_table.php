<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadoProyectoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empleadosProyecto',function(Blueprint $table){
			$table->string('idEmpleado',6);
			$table->string('ap_paterno',45);
			$table->string('ap_materno',45)->nullable();
			$table->string('nombres',45);
			$table->enum('genero',["femenino","masculino"]);
			$table->date('fecha_nacimiento');
			$table->string('curp', 18)->unique();
			$table->string('imss',11)->unique()->nullable();
			$table->integer('idestado')->unsigned();
			$table->timestamps();
			$table->primary('idEmpleado');
			//declarar las referencias de las llaves foraneas
			$table->foreign('idestado')->references('id_estados')->on('estados');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('empleadosProyecto');
	}

}
