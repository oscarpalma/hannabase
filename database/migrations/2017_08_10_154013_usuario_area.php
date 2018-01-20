<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsuarioArea extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users',function(Blueprint $table){
			$table->integer('id_area')->unsigned()->after('role');
			$table->foreign('id_area')->references('idAreaCt')->on('areas_ct');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropColumn('id_area');
		Schema::dropForeign('users_id_area_foreign');
	}

}
