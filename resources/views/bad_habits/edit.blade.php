@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">
		<div class="col-lg-12"> 
			<form method="POST" action="{{ $badHabit->path() }}" accept-charset="UTF-8" enctype="multipart/form-data">
				{{ method_field('PUT') }}
				
				@include('bad_habits.form', [
					'submitButtonText' => 'Edit Bad Habit'
				])
			</form>
		</div>
	</div>
@stop