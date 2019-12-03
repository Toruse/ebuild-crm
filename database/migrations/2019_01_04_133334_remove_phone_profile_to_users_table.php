<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePhoneProfileToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20);
        });
        
        $results = DB::table('user_profiles')->select('user_id', 'phone')->get();

        foreach($results as $result)
        {
            DB::table('users')
                ->where('id',$result->user_id)
                ->update([
                    "phone" => $result->phone
                ]);
        }

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('phone', 20);
        });

        $results = DB::table('users')->select('id', 'phone')->get();

        foreach($results as $result)
        {
            DB::table('user_profiles')
                ->where('user_id',$result->id)
                ->update([
                    "phone" => $result->phone
                ]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
}
