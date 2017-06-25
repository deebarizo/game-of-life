@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">
		<div class="col-lg-12"> 
			<form method="POST" action="/bad_habits" accept-charset="UTF-8" enctype="multipart/form-data">
				@include('bad_habits.form', [
					'submitButtonText' => 'Create Bad Habit'
				])
			</form>
		</div>
	</div>
@stop