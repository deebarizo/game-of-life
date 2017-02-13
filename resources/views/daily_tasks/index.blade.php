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

					<div class="text-center"><a href="#"><img src="<?php echo url('/files/icons/target.png'); ?>"></a> <a href="/daily_tasks/{{ $dailyTask->id }}/edit"><img src="<?php echo url('/files/icons/edit.png'); ?>"></a> <a href="#"><img src="<?php echo url('/files/icons/checked.png'); ?>"></a> <form style="display: inline" method="POST" action="/daily_tasks/{{ $dailyTask->id}}" accept-charset="UTF-8" id="form-delete-daily-tasks-{{ $dailyTask->id }}"><input name="_method" type="hidden" value="DELETE">{{ csrf_field() }}<a class="data-delete" data-form="daily-tasks-{{ $dailyTask->id }}" href="#"><img src="<?php echo url('/files/icons/trash.png'); ?>"></a></form></div>
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

			/****************************************************************************************
			DELETING A DAILY TASK
			****************************************************************************************/

			$(function () { // http://laraveldaily.com/resource-controller-delete-how-to-have-link-instead-of-a-submit-button/

				$('.data-delete').on('click', function (e) {
			    
			    	if (!confirm('Are you sure you want to delete?')) return;
			    
			    		e.preventDefault();
			    
			    	$('#form-delete-'+$(this).data('form')).submit();
			  	});
			});
		});		





	</script>
@stop