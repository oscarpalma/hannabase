<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialSistemasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('materialSistemas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('contrasena',30);
			$table->boolean('antivirus');
			$table->integer('idMaterial')->unsigned();
			

			$table->foreign('idMaterial')->references('id')->on('material')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('materialSistemas');
	}

}
