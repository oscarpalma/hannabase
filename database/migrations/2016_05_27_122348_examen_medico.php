<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExamenMedico extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('examen_medico',function(Blueprint $table){
			//los valores booleanos indican si el valor es positivo, mientras que los comentarios se puede agregar que tipo de condicion es, que circunstancias, etc
			$table->increments('id_examen');
			$table->integer('empleado')->unsigned();
			$table->boolean('antidoping');
			$table->boolean('embarazo');
			$table->boolean('vista'); //false significa que tiene buena vista
			$table->boolean('enfermedad');
			$table->string('antidoping_comentario');
			$table->string('embarazo_comentario');
			$table->string('vista_comentario'); 
			$table->string('enfermedad_comentario');
			$table->boolean('aprobado'); //si el candidato es apto para trabajar
			$table->timestamps();
			//declarar las referencias de las llaves foraneas
			$table->foreign('empleado')->references('idEmpleado')->on('empleados');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('examen_medico');
	}

}
