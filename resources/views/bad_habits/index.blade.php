@extends('master')

@section('content')

	@include('_form_heading')
	
	<div class="row">

		<div class="col-lg-12">

			<p style="margin-bottom: 20px"><a href="/bad_habits/create">Create Bad Habit</a></p>

		</div>

		@foreach ($badHabits as $badHabit)

			<?php 

				$isSuccess = ($badHabit->is_success ? 'success' : '');
			
			?>

			<div class="col-lg-4">

				<div class="bad-habit {{ $isSuccess }}" style="height: 250px; border: 1px solid; margin-bottom: 30px" data-bad-habit-instance-id="{{ $badHabit->bad_habit_instance_id }}">
					<h4 class="text-center" style="margin: 18px 18px">{{ $badHabit->name }}</h4>

					<img class="center-block" style="margin-bottom: 27px" src="<?php echo url($badHabit->image_url); ?>">

					<div class="text-center"><a href="/bad_habit/{{ $badHabit->id }}/edit"><img src="<?php echo url('/files/icons/edit.png'); ?>"></a> <a class="fail" href="#"><img src="<?php echo url('/files/icons/fail.png'); ?>"></a> <form style="display: inline" method="POST" action="/bad_habits/{{ $badHabit->id}}" accept-charset="UTF-8" id="form-delete-bad-habits-{{ $badHabit->id }}"><input name="_method" type="hidden" value="DELETE">{{ csrf_field() }}<a class="data-delete" data-form="bad-habits-{{ $badHabit->id }}" href="#"><img src="<?php echo url('/files/icons/trash.png'); ?>"></a></form></div>
				</div>

			</div>

		@endforeach

	</div>

	<script type="text/javascript">

		$(document).ready(function() {


			/****************************************************************************************
			GLOBAL VARIABLES
			****************************************************************************************/

			var baseUrl = '<?php echo url('/'); ?>';


			/****************************************************************************************
			AJAX SETUP
			****************************************************************************************/

			$.ajaxSetup({ // http://stackoverflow.com/a/37663496/1946525
			    
			    headers: {
			        
			        'X-CSRF-Token': $('input[name="_token"]').val()
			    }
			});


			/****************************************************************************************
			COMPLETING A DAILY TASK INSTANCE
			****************************************************************************************/

			$('a.fail').on('click', function(e) {

				e.preventDefault(e);

				var dailyTask = $(this).closest('div.daily-task');
				var dailyTaskInstanceId = dailyTask.attr('data-daily-task-instance-id');
				var isComplete = !dailyTask.hasClass('complete');

				$.ajax({

		            url: baseUrl+'/daily_task_instances/complete',
		           	type: 'POST',
		           	data: { 
		           	
		           		dailyTaskInstanceId: dailyTaskInstanceId,
		           		isComplete: isComplete
		           	},
		            success: function() {

		            	isComplete ? dailyTask.addClass('complete') : dailyTask.removeClass('complete');
		            }
		        });
			})


			/****************************************************************************************
			DELETING A DAILY TASK
			****************************************************************************************/

			$(function () { // http://laraveldaily.com/resource-controller-delete-how-to-have-link-instead-of-a-submit-button/

				$('.data-delete').on('click', function(e) {
			    
			    	if (!confirm('Are you sure you want to delete?')) return;
			    
			    		e.preventDefault();
			    
			    	$('#form-delete-'+$(this).data('form')).submit();
			  	});
			});
		});		

	</script>
@stop