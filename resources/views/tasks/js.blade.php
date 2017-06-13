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
				var taskId = task.attr('data-task-id');
				var isComplete = !task.hasClass('complete');

				$.ajax({

		            url: baseUrl+'/tasks/complete',
		           	type: 'POST',
		           	data: { 
		           		taskId: taskId,
		           		isComplete: isComplete
		           	},
		            success: function() {

		            	isComplete ? task.addClass('complete') : task.removeClass('complete');
		            }
		        });
			})
		});		

	</script>