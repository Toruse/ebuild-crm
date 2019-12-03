<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('project_type_id')->nullable();
            $table->unsignedInteger('project_manager_id')->nullable();
            $table->enum('status', ['open', 'sold', 'lost', 'complete', 'no_opportunity'])->nullable();
            $table->boolean('active')->default(true);

            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('project_manager_id');
            $table->foreign('project_manager_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->index('project_type_id');
            $table->foreign('project_type_id')
                ->references('id')
                ->on('project_types')
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
        Schema::dropIfExists('user_orders');
    }
}
