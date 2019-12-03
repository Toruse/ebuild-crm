<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->string('street_address1');
            $table->string('street_address2');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code', 15);
            $table->text('note')->nullable();
            $table->string('company')->nullable();
            $table->unsignedInteger('source_id')->nullable();
            $table->string('website')->nullable();
            $table->string('fax_number', 50)->nullable();
            $table->string('material_service')->nullable();
            $table->unsignedInteger('skill_specialty_id')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('source_id');
            $table->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->index('skill_specialty_id');
            $table->foreign('skill_specialty_id')
                ->references('id')
                ->on('skill_specialtys')
                ->onDelete('set null')
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
        Schema::dropIfExists('user_profiles');
    }
}
