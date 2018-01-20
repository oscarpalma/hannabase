<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBajasInventarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bajas_inventario',function(Blueprint $table){
			$table->increments('idBajasInventario');
			$table->integer("material")->unsigned();
			$table->integer("bajas")->unsigned();
			$table->integer("semana")->unsigned();
			
			$table->foreign('material')->references('id')->on('material')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bajas_inventario');
	}

}
