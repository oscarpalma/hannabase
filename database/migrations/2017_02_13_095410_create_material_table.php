<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('material', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('fecha');
			$table->string('nombre',45);
			$table->string('marca',45);
			$table->string('modelo',45);
			$table->longText('descripcion');
			$table->mediumText('accesorios');
			$table->enum('estado',['nuevo','seminuevo','malestado']);
			$table->integer('unidades')->unsigned();
			$table->decimal('precioUnitario',8,2);
			$table->decimal('precioTotal',8,2)->nullable();
			$table->string('codigoBarras',30);
			$table->string('foto',255);
			$table->integer('area')->unsigned();

			$table->foreign('area')->references('idArea')->on('areas_inventario')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('material');
	}

}
