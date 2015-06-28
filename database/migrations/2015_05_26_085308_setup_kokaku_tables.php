<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupKokakuTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('docs', function(Blueprint $table) {

			$table->increments('id');
			$table->string('filename')->default('');
			$table->string('originalFilename')->default('');
			$table->string('title')->default('');
			$table->string('number')->default('');
			$table->string('docType')->default('');
			$table->date('publishedDate')->default('0000-00-00');
			$table->date('validDate')->default('0000-00-00');
			$table->mediumText('description')->default('');
			$table->string('siteUrl')->default('');
			$table->string('docUrl')->default('');
			$table->timestamps();

		});

		Schema::create('enactments', function(Blueprint $table) {

			$table->increments('id');
			$table->integer('docId');
			$table->string('number');
			$table->date('publishedDate');
			$table->string('docName');
			$table->string('siteUrl')->default('');
			$table->string('docUrl')->default('');
			$table->timestamps();

		});

		Schema::create('altSiteUrls', function(Blueprint $table) {

			$table->increments('id');
			$table->integer('docId');
			$table->string('altSiteUrl');

		});

		Schema::create('altDocUrls', function(Blueprint $table) {

			$table->increments('id');
			$table->integer('docId');
			$table->string('altDocUrl');

		});

		Schema::create('unappliedEffects', function(Blueprint $table) {

			$table->increments('id');
			$table->integer('docId');
			$table->string('docNumber');
			$table->string('status');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('docs');

		Schema::drop('enactments');

		Schema::drop('altSiteUrls');

		Schema::drop('altDocUrls');
		
		Schema::drop('unappliedEffects');
	}

}
