<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacionTable extends Migration {

/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('autorizaciones',function(Blueprint $table){
			$table->increments('idAutorizacion');
			$table->string('solicitante',50);
			$table->date('fecha');
			$table->integer('idarea')->unsigned();
			$table->string('responsable',50);
			$table->string('concepto',160);
			$table->string('tipo_pago');
			$table->integer('idproveedor')->unsigned();
			$table->string('descripcion',250);
			$table->integer('precio_unitario');
			$table->integer('cantidad');
			$table->integer('total');
			//Se declara referencia de llave foranea
			$table->foreign('idarea')->references('idAreaCt')->on('areas_ct')->onDelete('cascade');
			$table->foreign('idproveedor')->references('id')->on('proveedores')->onDelete('cascade');

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
		Schema::drop('autorizaciones');
	}

}
