<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReembolsoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reembolso',function(Blueprint $table){
			$table->increments('idReembolso');
			$table->integer('idEmpleado')->unsigned();
			$table->integer('descuento')->unsigned();
			$table->date('fecha');
			$table->integer('semana')->unsigned();
			$table->string('comentario',200);
			$table->timestamps();
			//declarar las referencias de las llaves foraneas
			$table->foreign('idEmpleado')->references('idEmpleado')->on('empleados')->onDelete('cascade');
			$table->foreign('descuento')->references('idTipoDescuento')->on('tipo_descuento')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reembolso');
	}

}
