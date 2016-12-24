<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatosLocalizacionCt extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('datos_localizacion_ct',function(Blueprint $table){
			$table->integer('idEmpleadoCt')->unsigned();
			$table->integer('tel_casa')->unsigned();
			$table->integer('tel_cel')->unsigned();
			$table->string('calle',45);
			$table->string('no_interior',45);
			$table->integer('no_exterior')->unsigned();
			$table->integer('idColonia')->unsigned();
			$table->string('nombre_contacto',100);
			$table->integer('tel_contacto')->unsigned();
			$table->enum('tipo_parentesco',["esposa","esposo","madre","padre","hermana","hermano","tia","tio","abuela","abuelo","no especificado"]);

			//referencias llaves foraneas
			$table->foreign('idEmpleadoCt')->references('idEmpleadoCt')->on('empleados_ct');
			$table->foreign('idColonia')->references('idColonia')->on('colonias');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('datos_localizacion_ct');
	}

}
