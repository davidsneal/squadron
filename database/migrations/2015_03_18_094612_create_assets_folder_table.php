<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsFolderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assets_folders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_folder_id')->unsigned()->nullable();
			$table->string('name', 45);
			$table->string('desc', 125)->nullable();
			$table->string('dirpath', 400)->nullable();
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
		Schema::drop('assets_folders');
	}

}
