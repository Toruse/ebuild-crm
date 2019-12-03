<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeContractorIdInScheduleTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule_tasks', function (Blueprint $table) {
            $table->dropForeign(['contractor_id']);

            $table->unsignedInteger('contractor_id')->nullable()->change();

            $table->foreign('contractor_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('set null');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['contractor_id']);

            $table->unsignedInteger('contractor_id')->nullable()->change();

            $table->foreign('contractor_id')
                ->references('id')
                ->on('users')
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
        Schema::table('schedule_tasks', function (Blueprint $table) {
            $table->dropForeign(['contractor_id']);

            $table->unsignedInteger('contractor_id')->nullable(false)->change();

            $table->foreign('contractor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['contractor_id']);

            $table->unsignedInteger('contractor_id')->nullable(false)->change();

            $table->foreign('contractor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
