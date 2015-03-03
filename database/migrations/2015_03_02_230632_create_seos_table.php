<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('page_id')
				  ->unsigned()
			      ->nullable();
			$table->integer('article_id')
				  ->unsigned()
			      ->nullable();
			$table->string('title', 150)->nullable();
			$table->string('description', 255)->nullable();
			$table->string('type', 45)->nullable();
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
		Schema::drop('seos');
	}

}
