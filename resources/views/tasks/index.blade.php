@extends('master')

@section('content')

	@include('_form_heading')
	
	<div class="row">

		<div class="col-lg-12">

			<p style="margin-bottom: 20px"><a href="/tasks/create">Create Task</a></p>

		</div>

		@foreach ($tasks as $task)
			@include('tasks.task')
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