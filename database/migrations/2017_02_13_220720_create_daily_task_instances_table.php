<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyTaskInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_task_instances', function($table) 
        {
            $table->increments('id');
            $table->integer('daily_task_id')->unsigned();
            $table->foreign('daily_task_id')->references('id')->on('daily_tasks');
            $table->date('date');
            $table->integer('start_time'); 
            $table->integer('end_time'); 
            $table->boolean('is_complete');
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_task_instances');
    }
}
