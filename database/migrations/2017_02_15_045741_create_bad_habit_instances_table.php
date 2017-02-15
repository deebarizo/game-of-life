<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadHabitInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bad_habit_instances', function($table) 
        {
            $table->increments('id');
            $table->integer('bad_habit_id')->unsigned();
            $table->foreign('bad_habit_id')->references('id')->on('bad_habits');
            $table->date('date');
            $table->boolean('is_success');
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
        Schema::dropIfExists('bad_habit_instances');
    }
}
