<?php

use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function($table)
		{
		    $table->increments('id');
		    $table->integer('id_promotion');
		    $table->string('background');
		    $table->string('button');

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
		Schema::dropIfExists("images");
	}

}