<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
			$table->string('username', 255);
			$table->string('password', 128);
			$table->string('email', 255);
			$table->string('lastName', 50);
			$table->string('firstName', 50);
			$table->boolean('accountActive')->default(false);
            $table->timestamp('dateRegistered');
            $table->timestamp('lastLoginDate');
			$table->string('userProvince', 255);
			$table->string('userCity', 255);
			$table->string('mobileNo', 10);
			$table->string('landline', 7)->nullable();
        });
		
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('userId')->unsigned();
			$table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
			$table->string('type', 10);
			$table->string('title', 255);
			$table->text('description');
			$table->string('postProvince', 255);
			$table->string('postCity', 255);
            $table->timestamp('datePosted');
			$table->string('postActive', 20);
			$table->integer('views')->unsigned();
        });
		
        Schema::create('inbox_msgs', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('senderId')->unsigned();
			$table->foreign('senderId')->references('id')->on('users')->onDelete('cascade');
			$table->string('subject', 255);
			$table->text('body');
            $table->timestamp('date');
			$table->boolean('read')->default(false);
        });
		
        Schema::create('sent_msgs', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('recipientId')->unsigned();
			$table->foreign('recipientId')->references('id')->on('users')->onDelete('cascade');
			$table->string('subject', 255);
			$table->text('body');
            $table->timestamp('date');
			$table->boolean('read')->default(false);
        });
		
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('postId')->unsigned();
			$table->foreign('postId')->references('id')->on('posts')->onDelete('cascade');
            $table->text('url');
        });
		
        Schema::create('bookmarked_posts', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('userId')->unsigned();
			$table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
			$table->integer('postId')->unsigned();
			$table->foreign('postId')->references('id')->on('posts')->onDelete('cascade');
			$table->unique(array('userId', 'postId'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('posts');
        Schema::drop('inbox_msgs');
        Schema::drop('sent_msgs');
        Schema::drop('photos');
        Schema::drop('bookmarked_posts');
    }
}
