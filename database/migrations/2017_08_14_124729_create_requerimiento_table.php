<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequerimientoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requerimiento', function(Blueprint $table)
		{
			$table->increments('idRequerimiento');
			$table->longText('tabla');
			$table->integer('semana')->unsigned();
			$table->integer('year')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('requerimiento');
	}

}
