<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('logro',function(Blueprint $table){
			$table->increments('idLogro');
			$table->integer("plan")->unsigned();
			$table->integer('actual')->unsigned();
			$table->date('fecha');
			$table->integer('semana')->unsigned();
			$table->integer('pk_idTipoKpi')->unsigned();

			//referencias llaves foraneas
			$table->foreign("pk_idTipoKpi")->references('idTipoKpi')->on('tipoKpi')->onDelete('cascade');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('logro');
	}

}
