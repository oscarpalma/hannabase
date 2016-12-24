<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HistorialTabla extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('historial_acciones', function(Blueprint $table){
			$table->increments('idAccion');
			$table->integer('usuario')->unsigned();
			$table->string('descripcion');
			$table->timestamps();

			$table->foreign('usuario')->references('id')->on('users');
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
		Schema::drop('historial_acciones');
	}

}
