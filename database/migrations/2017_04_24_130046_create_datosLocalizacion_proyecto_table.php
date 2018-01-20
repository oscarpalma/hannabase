<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosLocalizacionProyectoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('datos_localizacionProyecto',function(Blueprint $table){
			$table->increments('id');
			$table->string('idEmpleado',6);
			$table->string('tel_casa',10);
			$table->string('tel_cel',10);
			$table->string('calle',45);
			$table->string('no_interior',45);
			$table->integer('no_exterior')->unsigned();
			$table->integer('idColonia')->unsigned();
			
			$table->timestamps();
			//Laves Foraneas
			$table->foreign('idEmpleado')->references('idEmpleado')->on('empleadosProyecto')->onDelete('cascade');
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
		Schema::drop('datos_localizacionProyecto');
	}

}
