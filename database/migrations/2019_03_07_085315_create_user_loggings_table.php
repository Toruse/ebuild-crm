<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoggingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_loggings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('session_id')->unique();
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->dateTime('login_user_time')->nullable();
            $table->dateTime('logout_user_time')->nullable();
            $table->dateTime('login_server_time')->nullable();
            $table->dateTime('logout_server_time')->nullable();
            $table->text('data')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_loggings');
    }
}
