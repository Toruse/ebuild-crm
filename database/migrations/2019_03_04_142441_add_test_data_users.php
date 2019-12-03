<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestDataUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //-- Client --
        $id = DB::table('users')->insertGetId([
            'name' => 'TestClient1',
            'email' => 'client1@test.com',
            'phone' => '+1 (693) 477-8426',
            'password' => bcrypt('123456'),
            'is_admin' => 1,
        ]);

        DB::table('user_roles')->insert([
            'user_id' => $id,
            'role_id' => 2,
        ]);

        DB::table('user_profiles')->insert($this->createNewProfile($id));

        DB::table('user_orders')->insert($this->createNewOrder($id));

        //-- Contractor --
        $id = DB::table('users')->insertGetId([
            'name' => 'TestContractor1',
            'email' => 'contractor1@test.com',
            'phone' => '+1 (693) 477-8426',
            'password' => bcrypt('123456'),
            'is_admin' => 1,
        ]);

        DB::table('user_roles')->insert([
            'user_id' => $id,
            'role_id' => 4,
        ]);

        DB::table('user_profiles')->insert($this->createNewProfile($id));

        DB::table('user_orders')->insert($this->createNewOrder($id));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    public function createNewProfile($userId)
    {
        return [
            'user_id' => $userId,
            'firstname' => 'Testfirstname',
            'lastname' => 'Testlastname',
            'email' => 'email',
            'street_address1' => 'street_address1',
            'street_address2' => 'street_address2',
            'city' => 'city',
            'state' => 'state',
            'postal_code' => 'postal_code',
            'note' => 'note',
        ];
    }

    public function createNewOrder($userId)
    {
        return [
            'user_id' => $userId,
            'status' => 1,
        ];
    }
}
