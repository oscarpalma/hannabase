<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notificaciones', function(Blueprint $table){
			$table->increments('idNotificaciones');
			$table->longText('mensaje');
			$table->boolean('visto');
			$table->dateTime('fecha');
			$table->string('area',50);
			$table->string('remitente',140);
			$table->string('asunto',64);
			$table->integer('destinatario')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notificaciones');
	}

}
