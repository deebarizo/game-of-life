@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">
		<div class="col-lg-12"> 
			<form method="POST" action="{{ $task->path() }}" accept-charset="UTF-8" enctype="multipart/form-data">
				{{ method_field('PUT') }}
				
				@include('tasks.form', [
					'submitButtonText' => 'Edit Task'
				])
			</form>
		</div>
	</div>
@stop