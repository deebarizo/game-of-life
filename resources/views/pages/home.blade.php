@extends('master')

@section('content')

	<div class="row">

	  	<div class="col-lg-6 thumbnail-container">	
	
	  		<a href="/daily_tasks">
	
		    	<div class="thumbnail clearfix">
	
		        	<img src="<?php echo url('/files/icons/clipboard.png'); ?>" class="pull-left">
	
			         	<div class="caption" class="pull-right">
		
			           	<h2>Daily Tasks</h2>
		
			           	<p>{{ $dailyTasks['progress']['numCompleteTasks'] }}/{{ $dailyTasks['progress']['numTasks'] }} Tasks Completed</p>
		
						<div class="progress">
							<div class="progress-bar" role="progressbar" style="width: {{ $dailyTasks['progress']['barWidth'] }}%;"></div>
						</div>
	
			        </div>

			    </div>
		
		    </a>
	
	    </div>

	  	<div class="col-lg-6 thumbnail-container">	
	
	  		<a href="/bad_habits">
	
		    	<div class="thumbnail clearfix">
	
		        	<img src="<?php echo url('/files/icons/no-smoking.png'); ?>" class="pull-left">
	
		         	<div class="caption" class="pull-right">
	
			           	<h2>Bad Habits</h2>
		
			           	<p>{{ $badHabits['progress']['streak'] }}/{{ $badHabits['progress']['goal'] }} Streak Progress | Success Rate: {{ $badHabits['percentage'] }}%</p>
		
						<div class="progress">
							<div class="progress-bar" role="progressbar" style="width: {{ $badHabits['progress']['barWidth'] }}%;"></div>
						</div>
		
			        </div>

			    </div>
	
		    </a>
	
	    </div>
	
	</div>

@stop