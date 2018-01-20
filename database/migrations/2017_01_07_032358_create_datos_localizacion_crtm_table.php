<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosLocalizacionCrtmTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('datos_localizacion_crtm',function(Blueprint $table){
			$table->increments('id');
			$table->integer('idEmpleado')->unsigned();
			$table->string('calle',100);
			$table->string('tel_casa',10);
			$table->string('tel_cel',10);
			$table->string('no_interior',45);
			$table->integer('no_exterior')->unsigned();
			$table->integer('idColonia')->unsigned();
			$table->string('nombre_contacto',100);
			$table->string('tel_contacto',10);
			$table->enum('tipo_parentesco',["esposa","esposo","madre","padre","hermana","hermano","tia","tio","abuela","abuelo","no especificado"]);

			//referencias llaves foraneas
			$table->foreign('idEmpleado')->references('idEmpleado')->on('empleados_crtm')->onDelete('cascade');
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
		Schema::drop('datos_localizacion_crtm');
	}

}
