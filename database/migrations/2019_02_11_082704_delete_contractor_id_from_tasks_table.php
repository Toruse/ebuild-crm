<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteContractorIdFromTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $results = DB::table('tasks')->select('id', 'contractor_id')->get();

        foreach($results as $result)
        {
            if ($result->contractor_id) {
                DB::table('task_users')->insert([
                    [
                        'task_id' => $result->id,
                        'user_id' => $result->contractor_id,
                    ],
                ]);    
            }
        } 

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['contractor_id']);
            $table->dropColumn('contractor_id');
        });

        $results = DB::table('schedule_tasks')->select('id', 'contractor_id')->get();

        foreach($results as $result)
        {
            if ($result->contractor_id) {
                DB::table('schedule_task_users')->insert([
                    [
                        'task_id' => $result->id,
                        'user_id' => $result->contractor_id,
                    ],
                ]);
            }
        } 

        Schema::table('schedule_tasks', function (Blueprint $table) {
            $table->dropForeign(['contractor_id']);
            $table->dropColumn('contractor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedInteger('contractor_id')->nullable();
        });

        $results = DB::table('tasks')->select('id', 'contractor_id')->get();

        foreach($results as $result)
        {
            $task_user = DB::table('task_users')
                ->select('id', 'user_id')
                ->where('task_id', $result->id)
                ->first();
            if ($task_user) {
                DB::table('tasks')
                    ->where('id',$result->id)
                    ->update([
                        'contractor_id' => $task_user->user_id
                    ]);
            }
        }    

        Schema::table('tasks', function (Blueprint $table) {            
            $table->index('contractor_id');
            $table->foreign('contractor_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('set null');
        });

        Schema::table('schedule_tasks', function (Blueprint $table) {
            $table->unsignedInteger('contractor_id')->nullable();
        });


        $results = DB::table('schedule_tasks')->select('id', 'contractor_id')->get();

        foreach($results as $result)
        {
            $task_user = DB::table('schedule_task_users')
                ->select('id', 'user_id')
                ->where('task_id', $result->id)
                ->first();

            if ($task_user) {
                DB::table('schedule_tasks')
                    ->where('id',$result->id)
                    ->update([
                        'contractor_id' => $task_user->user_id
                    ]);
            }
        }    

        Schema::table('schedule_tasks', function (Blueprint $table) {
            $table->index('contractor_id');
            $table->foreign('contractor_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
    }
}
