<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyingColumnsTableUserProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function ($table) {
            $table->string('lastname', 50)->nullable()->change();
            $table->string('email', 100)->nullable()->change();
            $table->string('phone', 20)->nullable()->change();
            $table->string('street_address1')->nullable()->change();
            $table->string('street_address2')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('postal_code', 15)->nullable()->change();
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
            $table->string('lastname', 50)->nullable(false)->change();
            $table->string('email', 100)->nullable(false)->change();
            $table->string('phone', 20)->nullable(false)->change();
            $table->string('street_address1')->nullable(false)->change();
            $table->string('street_address2')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('state')->nullable(false)->change();
            $table->string('postal_code', 15)->nullable(false)->change();
        });
    }
}
