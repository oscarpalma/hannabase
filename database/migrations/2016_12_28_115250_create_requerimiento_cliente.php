<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequerimientoCliente extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('requerimientos',function(Blueprint $table){
			$table->increments('idRequerimiento');
			$table->integer('requerimiento');
			$table->integer('ingreso');
			$table->date('fecha_ingreso');
			$table->integer('semana')->unsigned();
			$table->integer('idcliente')->unsigned();
			$table->integer('idusuario')->unsigned();
			//Se declara referencia de llave foranea
			$table->foreign('idcliente')->references('idCliente')->on('clientes')->onDelete('cascade');
			$table->foreign('idusuario')->references('id')->on('users')->onDelete('cascade');

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
		Schema::drop('requerimientos');
	}

}
