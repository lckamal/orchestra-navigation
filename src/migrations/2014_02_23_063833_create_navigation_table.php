<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navigation_groups', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title')->unique();
			$table->string('abbrev')->unique();
			$table->timestamps();
		});

		Schema::create('navigation_links', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 100)->unique();
			$table->unsignedInteger('parent');
			$table->enum('link_type', array('url','uri','page'))->default('page');
			$table->unsignedInteger('page_id');
			$table->string('url')->nullable();
			$table->string('uri')->nullable();
			$table->unsignedInteger('navigation_group_id');
			$table->integer('position');
			$table->enum('target', array('_self','_blank'))->default('_self');
			$table->string('restricted_to')->nullable();
			$table->string('class', 50)->nullable();
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
		Schema::drop('navigation_links');
		Schema::drop('navigation_groups');
	}

}
