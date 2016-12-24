<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clientes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes',function(Blueprint $table){
			$table->increments('idCliente');
			$table->string('nombre',45);
			$table->string('direccion',45);
			$table->integer('telefono')->unsigned();
			$table->string('contacto',45);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clientes');
	}

}
