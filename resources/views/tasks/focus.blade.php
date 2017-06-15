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

			<div style="text-align: center; display: none" class="earned-link"><h4>Congrats! You have earned this <a href="/">link</a>.</h4></div>
		</div>

	</div>

	@include('tasks.js')

@stop