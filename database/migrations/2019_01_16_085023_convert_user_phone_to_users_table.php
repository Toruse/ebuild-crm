<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertUserPhoneToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $results = DB::table('users')->select('id', 'phone')->get();

        foreach($results as $result)
        {
            if (strlen($result->phone) == 17) continue;
            $result->phone;
            $result->phone = preg_replace("/[^+0-9]/", '', $result->phone);
            if (strlen($result->phone)<11) {
                $result->phone = '+1'.$result->phone;
            }
            $result->phone = substr($result->phone, 0, 2)." (".substr($result->phone, 2, 3).") ".substr($result->phone, 5, 3).'-'.substr($result->phone, 8, 4);

            DB::table('users')
                ->where('id',$result->id)
                ->update([
                    "phone" => $result->phone
                ]);
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
