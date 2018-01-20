<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescuentoCrtmTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('descuento_crtm',function(Blueprint $table){
			$table->increments('idDescuento');
			$table->integer('idEmpleado')->unsigned();
			$table->decimal('monto',8,2);
			$table->string('concepto',255);
			$table->date('fecha');
			$table->integer('semana')->unsigned();
			
			$table->timestamps();
			//declarar las referencias de las llaves foraneas
			$table->foreign('idEmpleado')->references('idEmpleado')->on('empleados_crtm')->onDelete('cascade');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('descuento_crtm');
	}

}