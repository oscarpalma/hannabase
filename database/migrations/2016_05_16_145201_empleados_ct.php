<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmpleadosCt extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empleados_ct',function(Blueprint $table){
			$table->increments('idEmpleadoCt');
			$table->string('ap_paterno',45);
			$table->string('ap_materno',45)->nullable();
			$table->string('nombres',45);
			$table->enum('genero',["femenino","masculino"]);
			$table->date('fecha_nacimiento');
			$table->string('curp', 18)->unique();
			$table->string('imss',11)->unique()->nullable();
			$table->string('rfc', 13)->unique()->nullable();
			$table->string('no_cuenta')->unique()->nullable();
			$table->integer('area')->unsigned();
			$table->integer('idestado')->unsigned();
			$table->timestamps();
			//declarar las referencias de las llaves foraneas
			$table->foreign('area')->references('idAreaCt')->on('areas_ct');
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
		Schema::drop('empleados_ct');
	}

}
