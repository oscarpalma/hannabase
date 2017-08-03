<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('temporales',function(Blueprint $table){
			$table->increments('idTemporal');
			$table->string('proveedor',100);
			$table->string('descripcion',250);
			$table->integer('precio_unitario');
			$table->integer('cantidad');
			$table->integer('total');
			$table->integer('idcotizacion')->unsigned();
			//Se declara referencia de llave foranea
			$table->foreign('idcotizacion')->references('idCotizacion')->on('cotizaciones')->onDelete('cascade');
			

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('temporales');
	}

}
