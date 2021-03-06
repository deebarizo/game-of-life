@extends('master_focus')

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<h2>Focus Mode</h2>
			<hr>
		</div>
	</div>

	<div class="row">

		<?php 

			$isComplete = ($instance->is_complete ? 'complete' : '');
			$description = ($instance->description == '' ? '' : '<a class="description" href="#"><img src="'.url('/files/icons/text-lines.png').'"></a><div style="display: none" class="tool-tip-description">'.$instance->description.'</div>');
			$link = ($instance->link == '' ? '' : '<a target="_blank" href="'.$instance->link.'"><img src="'.url('/files/icons/link.png').'"></a>');
			$star = ($instance->is_in_history ===  1 ? '<img src="'.url('/files/icons/star.png').'">' : '');

		?>

		<div class="col-lg-offset-4 col-lg-4">

			<div class="instance {{ $isComplete }}" style="height: 250px; border: 1px solid; margin-bottom: 30px; margin-top: 20px" data-instance-id="{{ $instance->id }}" data-instance-type="{{ $instanceType }}">
				<h4 class="text-center" style="margin: 18px 18px">{{ $instance->name }} {!! $description !!} {!! $link !!} {!! $star !!}</h4>

				<img class="center-block" style="margin-bottom: 27px" src="<?php echo url($instance->image_url); ?>">

				<div class="text-center"><a class="complete" href="#"><img src="<?php echo url('/files/icons/checked.png'); ?>"></a>{{ csrf_field() }}</div>
			</div>

			<div style="text-align: center; display: none" class="earned-link"><h4>Congrats! You have earned this <a href="/{{ $instanceType }}s">link</a>.</h4></div>

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