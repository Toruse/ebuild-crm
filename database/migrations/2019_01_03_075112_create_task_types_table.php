<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedInteger('task_type_id')->nullable();

            $table->index('task_type_id');
            $table->foreign('task_type_id')
                ->references('id')
                ->on('task_types')
                ->onDelete('set null')
                ->onUpdate('set null');
        });

        Schema::table('schedule_tasks', function (Blueprint $table) {
            $table->unsignedInteger('task_type_id')->nullable();

            $table->index('task_type_id');
            $table->foreign('task_type_id')
                ->references('id')
                ->on('task_types')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function ($table) {
            $table->dropForeign(['task_type_id']);
            $table->dropColumn('task_type_id');
        });

        Schema::table('schedule_tasks', function ($table) {
            $table->dropForeign(['task_type_id']);
            $table->dropColumn('task_type_id');
        });

        Schema::dropIfExists('task_types');
    }
}
