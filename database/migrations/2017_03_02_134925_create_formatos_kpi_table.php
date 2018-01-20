<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatosKpiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('formato_kpi', function(Blueprint $table)
		{
			$table->increments('idFormato');
			$table->longText('tabla');
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
		Schema::drop('formato_kpi');
	}

}
