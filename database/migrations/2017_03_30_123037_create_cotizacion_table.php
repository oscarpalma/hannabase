<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cotizaciones',function(Blueprint $table){
			$table->increments('idCotizacion');
			$table->string('solicitante',50);
			$table->date('fecha');
			$table->integer('idarea')->unsigned();
			$table->string('responsable',50);
			$table->string('concepto',160);
			$table->string('tipo_pago');

			//Se declara referencia de llave foranea
			$table->foreign('idarea')->references('idAreaCt')->on('areas_ct')->onDelete('cascade');
			

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cotizaciones');
	}

}
