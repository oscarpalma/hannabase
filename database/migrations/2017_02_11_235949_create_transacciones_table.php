<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaccionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transacciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('proveedor')->unsigned();
			$table->string('factura');
			$table->string('concepto');
			$table->integer('semana')->unsigned();
			$table->date('fecha_captura');
			$table->date('fecha_agendada');
			$table->decimal('cargo',8,2);
			$table->decimal('abono',8,2)->nullable();
			$table->decimal('saldo',8,2)->nullable();
			$table->date('fecha_programada');
			$table->date('fecha_traspaso')->nullable();
			$table->string('cheque');
			$table->timestamps();

			$table->foreign('proveedor')->references('id')->on('proveedores')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transacciones');
	}

}
