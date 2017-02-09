<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoKpiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipoKpi',function(Blueprint $table){
			$table->increments('idTipoKpi');
			$table->string("nombre",100);
			$table->string("unidad",45);
			$table->integer('pk_idAreaCt')->unsigned();
			
			//referencias llaves foraneas
			$table->foreign("pk_idAreaCt")->references('idAreaCt')->on('areas_ct')->onDelete('cascade');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tipoKpi');
	}

}
