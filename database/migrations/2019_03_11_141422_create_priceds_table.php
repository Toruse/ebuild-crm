<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priceds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->boolean('default')->default(false);
            $table->boolean('repeat')->default(false);
            $table->integer('period')->nullable();
            $table->string('period_type', 20)->nullable();
            $table->string('price', 25)->nullable();
            $table->date('end_date')->nullable();
            $table->text('note')->nullable();
            $table->text('settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('priceds');
    }
}
