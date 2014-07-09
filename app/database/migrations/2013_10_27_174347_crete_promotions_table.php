<?php

use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promotions', function($table)
		{
		    $table->increments('id');
		    $table->integer('id_user');
		    $table->string('name');
		    $table->string('description');
		    $table->dateTime('start-date');
		    $table->dateTime('end-date');
		    $table->string('link');
		    $table->string('font-color');


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
		Schema::dropIfExists("promotions");
	}

}