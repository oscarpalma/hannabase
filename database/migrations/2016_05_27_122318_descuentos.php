<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Descuentos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('descuento',function(Blueprint $table){
			$table->increments('id_descuentos');
			$table->integer('empleado')->unsigned();
			$table->integer('descuento')->unsigned();
			$table->date('fecha');
			$table->integer('semana')->unsigned();
			$table->string('comentario',200);
			$table->timestamps();
			//declarar las referencias de las llaves foraneas
			$table->foreign('empleado')->references('idEmpleado')->on('empleados');
			$table->foreign('descuento')->references('id_descuento')->on('tipo_descuento');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('descuento');
	}

}
