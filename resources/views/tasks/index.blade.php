@extends('master')

@section('content')

	@include('_form_heading')
	
	<div class="row">

		<div class="col-lg-12">

			<p style="margin-bottom: 20px"><a href="/tasks/create">Create Task</a></p>

		</div>

		@foreach ($tasks as $task)

			<?php 

				$isComplete = ($task->is_complete ? 'complete' : '');
				$description = ($task->description == '' ? '' : '<a class="description" href="#"><img src="'.url('/files/icons/text-lines.png').'"></a><div style="display: none" class="tool-tip-description">'.$task->description.'</div>');
				$link = ($task->link == '' ? '' : '<a target="_blank" href="'.$task->link.'"><img src="'.url('/files/icons/link.png').'"></a>');
			
			?>

			<div class="col-lg-4">

				<div class="task {{ $isComplete }}" style="height: 250px; border: 1px solid; margin-bottom: 30px" data-task-instance-id="{{ $task->id }}">
					<h4 class="text-center" style="margin: 18px 18px">{{ $task->name }} {!! $description !!} {!! $link !!}</h4>

					<img class="center-block" style="margin-bottom: 27px" src="<?php echo url($task->image_url); ?>">

					<div class="text-center"><a href="/focus/task/{{ $task->id }}"><img src="<?php echo url('/files/icons/target.png'); ?>"></a> <a href="/tasks/{{ $task->id }}/edit"><img src="<?php echo url('/files/icons/edit.png'); ?>"></a> <a class="complete" href="#"><img src="<?php echo url('/files/icons/checked.png'); ?>"></a> <form style="display: inline" method="POST" action="/tasks/{{ $task->id}}" accept-charset="UTF-8" id="form-delete-tasks-{{ $task->id }}"><input name="_method" type="hidden" value="DELETE">{{ csrf_field() }}<a class="data-delete" data-form="tasks-{{ $task->id }}" href="#"><img src="<?php echo url('/files/icons/trash.png'); ?>"></a></form></div>
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
			TOOLTIPS (DESCRIPTIONS)
			****************************************************************************************/

			$('a.description').on('mouseenter', function(event) {

		        $(this).qtip({
		        
		            content: {
		        
		                text: $(this).next('.tool-tip-description')
					},

					position: {

						my: 'left center',
						at: 'center right',
						target: $(this)
					},
					overwrite: false,
		            show: {
		                event: event.type,
		                ready: true
		            }
		        });
			});


			/****************************************************************************************
			AJAX SETUP
			****************************************************************************************/

			$.ajaxSetup({ // http://stackoverflow.com/a/37663496/1946525
			    
			    headers: {
			        
			        'X-CSRF-Token': $('input[name="_token"]').val()
			    }
			});


			/****************************************************************************************
			COMPLETING A TASK
			****************************************************************************************/

			$('a.complete').on('click', function(e) {

				e.preventDefault(e);

				var task = $(this).closest('div.task');
				var taskInstanceId = task.attr('data-task-instance-id');
				var isComplete = !task.hasClass('complete');


				$.ajax({

		            url: baseUrl+'/tasks/complete',
		           	type: 'POST',
		           	data: { 
		           	
		           		taskInstanceId: taskInstanceId,
		           		isComplete: isComplete
		           	},
		            success: function() {

		            	isComplete ? task.addClass('complete') : task.removeClass('complete');
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