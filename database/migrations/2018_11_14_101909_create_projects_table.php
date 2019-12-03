<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_type_id')->nullable();
            $table->unsignedInteger('project_manager_id')->nullable();
            $table->unsignedInteger('customer_id');
            $table->string('street_address1')->nullable();
            $table->string('street_address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code', 15)->nullable();
            $table->float('price', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->string('color', 10)->nullable();
            $table->enum('schedule', ['scratch', 'template']);
            $table->timestamps();

            $table->index('customer_id');
            $table->foreign('customer_id')
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
        Schema::dropIfExists('projects');
    }
}
