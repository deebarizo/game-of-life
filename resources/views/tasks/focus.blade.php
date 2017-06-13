@extends('master_focus')

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<h2>Focus Mode</h2>
			<hr>
		</div>
	</div>

	<div class="row">

		<div class="col-lg-offset-4 col-lg-4">
			@include('tasks.task')

			<div style="text-align: center; display: none" class="earned-link"><h4>Congrats! You have earned this <a href="#">link</a>.</h4></div>
		</div>

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
			COMPLETING AN INSTANCE
			****************************************************************************************/

			$('a.complete').on('click', function(e) {

				e.preventDefault(e);

				var instance = $(this).closest('div.instance');
				var instanceId = instance.attr('data-instance-id');
				var isComplete = !instance.hasClass('complete');

				var instanceType = instance.attr('data-instance-type');

				if (instanceType == 'daily_task') {

					$.ajax({

			            url: baseUrl+'/daily_task_instances/complete',
			           	type: 'POST',
			           	data: { 
			           	
			           		dailyTaskInstanceId: instanceId,
			           		isComplete: isComplete
			           	},
			            success: function() {

							if (isComplete) {

								instance.addClass('complete');
								$('div.earned-link').show();
							
							} else {

								instance.removeClass('complete');
							}
			            }
			        });
				}

				if (instanceType == 'task') {

					$.ajax({

			            url: baseUrl+'/tasks/complete',
			           	type: 'POST',
			           	data: { 
			           	
			           		taskInstanceId: instanceId,
			           		isComplete: isComplete
			           	},
			            success: function() {

							if (isComplete) {

								instance.addClass('complete');
								$('div.earned-link').show();
							
							} else {

								instance.removeClass('complete');
							}
			            }
			        });
				}
			})
		});		

	</script>

@stop