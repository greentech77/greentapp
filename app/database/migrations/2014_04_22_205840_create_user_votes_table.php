<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserVotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_votes', function($table)
		{
		    $table->increments('id');
		    $table->integer('id_user', false, 11);
		    $table->string('email',30);
		    $table->string('name',60);
		    $table->string('firstname',20);
		    $table->string('lastname',40);
		    $table->string('gender',6);
		    $table->string('ip',30);
		    $table->timestamp('votetime');
		    $table->tinyInteger('num_invites');
		    $table->tinyInteger('num_shares');


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
		Schema::dropIfExists("users_votes");
	}

}