<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogrosKpiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('logro_kpi', function(Blueprint $table)
		{
			$table->increments('idLogro');
			$table->longText('tabla');
			$table->integer('semana')->unsigned();
			$table->integer('year')->unsigned();
			$table->integer('area')->unsigned();

			$table->foreign('area')->references('idAreaKpi')->on('areas_kpi')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('logro_kpi');
	}

}
