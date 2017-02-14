@extends('master')

@section('content')

	<div class="row">
	  	<div class="col-lg-6">	
	  		<a href="/daily_tasks">
		    	<div class="thumbnail clearfix">
		        	<img src="<?php echo url('/files/icons/clipboard.png.'); ?>" class="pull-left">
		         	<div class="caption" class="pull-right">
		           	<h2>Daily Tasks</h2>
		           	<p>{{ $progressArray['numCompleteTasks'] }}/{{ $progressArray['numTasks'] }} Tasks Completed</p>
					<div class="progress">
						<div class="progress-bar" role="progressbar" style="width: {{ $progressArray['barWidth'] }}%;"></div>
					</div>
		        </div>
		    </a>
	    </div>
	</div>

@stop