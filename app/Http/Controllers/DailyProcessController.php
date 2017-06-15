<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UseCases\DailyTasksProcessor;

class DailyProcessController extends Controller
{
    public function run_daily_process()
    {
        $todayDate = new \DateTime;
        $dateString = $todayDate->format('Y-m-d');

        $dailyTasksProcessor = new DailyTasksProcessor;

        $dailyTasksProcessor->generate_daily_tasks($todayDate);

        return redirect('/');
    }
}
