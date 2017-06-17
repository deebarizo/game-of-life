@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">
		<div class="col-lg-12"> 
			<form method="POST" action="/tasks" accept-charset="UTF-8" enctype="multipart/form-data">
				@include('tasks.form', [
					'submitButtonText' => 'Create Task'
				])
			</form>
		</div>
	</div>
@stop