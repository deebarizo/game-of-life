@extends('master')

@section('content')

	@include('_form_heading')
	
	<div class="row">

		<div class="col-lg-12">

			<p style="margin-bottom: 20px"><a href="/daily_tasks/create">Create Daily Task</a></p>

		</div>

		@foreach ($dailyTasks as $dailyTask)

			<div class="col-lg-4">

				<div style="height: 250px; border: 1px solid">
					<h4 class="text-center" style="margin: 18px 18px">{{ $dailyTask->name }}</h4>

					<img class="center-block" style="margin-bottom: 27px" src="<?php echo url($dailyTask->image_url); ?>">

					<div class="text-center">Focus | Link | Complete</div>
				</div>

			</div>

		@endforeach

	</div>
@stop