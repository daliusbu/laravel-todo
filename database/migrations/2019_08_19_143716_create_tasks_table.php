<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task_name', 128);
            $table->text('task_description')->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->dateTime('completed_date')->nullable();
            $table->timestamps();

            // Foregins
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');

            // Engine
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_lithuanian_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
