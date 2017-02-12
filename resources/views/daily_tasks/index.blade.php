@extends('master')

@section('content')

	@include('_form_heading')
	
	<div class="row">

		<div class="col-lg-12">

			<p style="margin-bottom: 20px"><a href="/daily_tasks/create">Create Daily Task</a></p>

		</div>

		@foreach ($dailyTasks as $dailyTask)

			<?php 

				$description = ($dailyTask->description == '' ? '' : '<a class="description" href="#"><img src="'.url('/files/icons/text-lines.png').'"></a><div style="display: none" class="tool-tip-description">'.$dailyTask->description.'</div>');
				$link = ($dailyTask->link == '' ? '' : '<a target="_blank" href="'.$dailyTask->link.'"><img src="'.url('/files/icons/link.png').'"></a>');
			
			?>

			<div class="col-lg-4">

				<div style="height: 250px; border: 1px solid; margin-bottom: 30px">
					<h4 class="text-center" style="margin: 18px 18px">{{ $dailyTask->name }} {!! $description !!} {!! $link !!}</h4>

					<img class="center-block" style="margin-bottom: 27px" src="<?php echo url($dailyTask->image_url); ?>">

					<div class="text-center"><a href="#">Focus</a> | <a href="/daily_tasks/{{ $dailyTask->id }}/edit">Edit</a> | <a href="#">Complete</a></div>
				</div>

			</div>

		@endforeach

	</div>

	<script type="text/javascript">

		$(document).ready(function() {

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
		});		

	</script>
@stop