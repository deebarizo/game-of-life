@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		<form method="POST" action="/bad_habits/{{ $badHabit->id }}" accept-charset="UTF-8">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">

			<div class="col-lg-6"> 
				<div class="form-group">
					<label for="name">Name:</label>
						<input class="form-control" name="name" type="text" value="{{ $badHabit->name }}" id="name">
				</div>
			</div>

			<div class="col-lg-12"> 
				<input class="btn btn-primary" type="submit" value="Submit">
			</div>

		</form>

	</div>
@stop