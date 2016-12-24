<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComedorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comedores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('idEmpleado')->unsigned();
			$table->integer('semana')->unsigned();
			$table->date('fecha');
			$table->integer('cantidad')->unsigned();
			
			$table->foreign('idEmpleado')->references('idEmpleado')->on('empleados');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comedores');
	}

}
