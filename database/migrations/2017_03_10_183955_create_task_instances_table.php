<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_instances', function($table)
        {
            $table->increments('id');
            $table->text('name');
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->string('image_url');
            $table->integer('order');
            $table->date('date');
            $table->integer('start_time');
            $table->integer('end_time');
            $table->boolean('is_complete');
            $table->dateTime('completed_at')->nullable();
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
        Schema::dropIfExists('task_instances');
    }
}
