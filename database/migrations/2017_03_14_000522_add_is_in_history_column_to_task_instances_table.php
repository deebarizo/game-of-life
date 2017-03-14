<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsInHistoryColumnToTaskInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_instances', function ($table)
        {
            $table->boolean('is_in_history')->after('image_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_instances', function ($table) 
        {
            $table->dropColumn('is_in_history');
        });
    }
}
