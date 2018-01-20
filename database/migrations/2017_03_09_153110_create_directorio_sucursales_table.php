<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectorioSucursalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('directorio_sucursales',function(Blueprint $table){
			$table->increments('idDirectorioS');
			$table->string("sucursal",100);
			$table->string("telefonos",255);
			//$table->string("horario",255);
			$table->integer("area")->unsigned();	

			$table->foreign('area')->references('idArea')->on('areas_crtm')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('directorio_sucursales');
	}

}
