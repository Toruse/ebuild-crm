<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSkillSpecialtysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropForeign(['skill_specialty_id']);
            $table->dropColumn('skill_specialty_id');   
        });

        Schema::create('user_skill_specialtys', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('skill_specialty_id');
            $table->timestamps();

            $table->index(['user_id', 'skill_specialty_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('skill_specialty_id')
                ->references('id')
                ->on('skill_specialtys')
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
        Schema::dropIfExists('user_material_services');

        Schema::table('user_profiles', function($table) {
            $table->unsignedInteger('skill_specialty_id')->nullable();
        });
    }
}
