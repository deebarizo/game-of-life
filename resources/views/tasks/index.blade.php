@extends('master')

@section('content')

	@include('_form_heading')
	
	<div class="row">

		<div class="col-lg-12">

			<p style="margin-bottom: 20px"><a href="/tasks/create">Create Task</a></p>

		</div>

		@foreach ($tasks as $task)
			<div class="col-lg-4">
				@include('tasks.task')
			</div>
		@endforeach

	</div>

	@include('tasks.js')

@stop