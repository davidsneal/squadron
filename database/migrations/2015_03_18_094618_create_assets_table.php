<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 45);
			$table->integer('assets_folder_id')->unsigned()->nullable();
			$table->foreign('assets_folder_id')
				  ->references('id')->on('assets_folders')
				  ->onDelete('cascade');
			$table->string('desc', 125)->nullable();
			$table->string('alt', 45)->nullable();
			$table->string('filetype', 10);
			$table->string('extension', 10);
			$table->string('filepath', 400);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('assets');
	}

}
