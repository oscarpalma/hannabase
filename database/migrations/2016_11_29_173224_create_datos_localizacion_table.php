<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosLocalizacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('datos_localizacion',function(Blueprint $table){
			$table->increments('id');
			$table->integer('idEmpleado')->unsigned();
			$table->string('tel_casa',10);
			$table->string('tel_cel',10);
			$table->string('calle',45);
			$table->string('no_interior',45);
			$table->integer('no_exterior')->unsigned();
			$table->integer('idColonia')->unsigned();
			$table->string('nombre_contacto',100);
			$table->integer('tel_contacto')->unsigned();
			$table->enum('tipo_parentesco',["esposa","esposo","madre","padre","hermana","hermano","tia","tio","abuela","abuelo","no especificado"]);
			$table->timestamps();
			//Laves Foraneas
			$table->foreign('idEmpleado')->references('idEmpleado')->on('empleados')->onDelete('cascade');
			$table->foreign('idColonia')->references('idcolonia')->on('colonias');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('datos_localizacion');
	}

}
