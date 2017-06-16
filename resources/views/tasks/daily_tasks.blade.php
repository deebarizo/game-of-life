@extends('master')

@section('content')

	@include('_form_heading')
	
	<div class="row">

		<div class="col-lg-12">
			@if (count($tasks) == 0)
				<div style="display: inline">
					<a href="/tasks/create">Create Task</a>
					
					<form style="display: inline" method="POST" action="/run_daily_process" accept-charset="UTF-8">{{ csrf_field() }}<button style="margin-bottom: 10px;" class="btn btn-primary pull-right" type="submit">Run Daily Process</button></form>
				</div>
			@endif

			@if (count($tasks) > 0)
				<p style="margin-bottom: 20px"><a href="/tasks/create">Create Task</a></p>
			@endif
		</div>

		@foreach ($tasks as $task)
			<div class="col-lg-4">
				@include('tasks.task', [
					'hasFocusIcon' => true
				])
			</div>
		@endforeach

	</div>

	@include('tasks.js')

@stop
