<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSheduleTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id')->nullable();
            $table->unsignedInteger('contractor_id');
            $table->unsignedInteger('reminder_id')->nullable();
            $table->string('name', 255);
            $table->string('color', 10)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('schedule_id');
            $table->foreign('schedule_id')
                ->references('id')
                ->on('schedules')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('contractor_id');
            $table->foreign('contractor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('reminder_id');
            $table->foreign('reminder_id')
                ->references('id')
                ->on('view_contacts')
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
        Schema::dropIfExists('schedule_tasks');
    }
}
