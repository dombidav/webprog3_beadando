<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('full_name')->nullable();
            $table->tinyInteger('hide_name')->default(1); //0 - public ; 1 - contacts only ; 2 - all
            $table->string('email')->unique();
            $table->tinyInteger('hide_email')->default(1);
            $table->string('password');
            $table->string('image')->nullable();
            $table->tinyInteger('hide_image')->default(1);
            $table->string('git')->nullable();
            $table->string('hide_git')->default(1);
            $table->rememberToken();
            $table->tinyInteger('auth')->nullable();
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
        Schema::dropIfExists('users');
    }
}
