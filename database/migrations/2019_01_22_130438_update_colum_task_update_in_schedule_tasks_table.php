<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumTaskUpdateInScheduleTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $results = DB::table('schedule_tasks')->select('id', 'name', 'task_type_id')->get();

        foreach($results as $result)
        {
            $task_type = DB::table('task_types')
                ->select('id', 'name')
                ->where('name', $result->name)
                ->orWhere('id', $result->task_type_id)
                ->first();
            if (!$task_type) {
                $task_type = DB::table('task_types')->select('id', 'name')->first();
            }

            if ($task_type->id != $result->task_type_id) {
                DB::table('schedule_tasks')
                    ->where('id',$result->id)
                    ->update([
                        "task_type_id" => $task_type->id
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
