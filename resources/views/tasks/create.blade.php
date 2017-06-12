@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		<form method="POST" action="/tasks" accept-charset="UTF-8" enctype="multipart/form-data">
			@include('tasks.form', [
				'submitButtonText' => 'Create Task'
			])
		</form>

	</div>
@stop