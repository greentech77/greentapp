<?php

use Illuminate\Database\Migrations\Migration;

class CreateCorrectAnwsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('correct_anwsers', function($table)
		{
		//
			$table->increments('id');
			$table->integer('id_question', false, 10);
			$table->integer('id_anwser', false, 10);
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
		//
		Schema::dropIfExists("correct_anwsers");
	}

}