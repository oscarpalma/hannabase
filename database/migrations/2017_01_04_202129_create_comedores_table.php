<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComedoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comedores', function(Blueprint $table)
		{
			$table->increments('idComedores');
			$table->integer('idEmpleado')->unsigned();
			$table->integer('semana')->unsigned();
			$table->date('fecha');
			$table->integer('cantidad')->unsigned();
			$table->timestamps();
			$table->foreign('idEmpleado')->references('idEmpleado')->on('empleados')->onDelete('cascade');
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
