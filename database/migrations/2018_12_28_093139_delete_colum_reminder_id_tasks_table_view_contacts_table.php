<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumReminderIdTasksTableViewContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function ($table) {
            $table->dropForeign(['reminder_id']);
            $table->dropColumn('reminder_id');
        });

        Schema::table('schedule_tasks', function ($table) {
            $table->dropForeign(['reminder_id']);
            $table->dropColumn('reminder_id');
        });

        Schema::dropIfExists('view_contacts');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('view_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('type', 50);
            $table->date('date')->nullable();
            $table->string('subject')->default('');
            $table->dateTime('reminder')->nullable();
            $table->text('note')->nullable();
            $table->string('search')->nullable();
            

            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->unsignedInteger('reminder_id')->nullable();
            
            $table->index('reminder_id');
            $table->foreign('reminder_id')
                ->references('id')
                ->on('view_contacts')
                ->onDelete('set null')
                ->onUpdate('set null');
        });

        Schema::create('schedule_tasks', function (Blueprint $table) {
            $table->unsignedInteger('reminder_id')->nullable();

            $table->index('reminder_id');
            $table->foreign('reminder_id')
                ->references('id')
                ->on('view_contacts')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
    }
}
