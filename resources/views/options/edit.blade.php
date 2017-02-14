@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		<form method="POST" action="/options/{{ $option->id }}" accept-charset="UTF-8">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">

			<div class="col-lg-2"> 
				<div class="form-group">
					<label for="start_time">Start Time:</label>
						<input class="form-control" name="start_time" type="text" value="{{ $option->start_time }}" id="start_time">
				</div>
			</div>

			<div class="col-lg-2"> 
				<div class="form-group">
					<label for="end_time">End Time:</label>
						<input class="form-control" name="end_time" type="text" value="{{ $option->end_time }}" id="end_time">
				</div>
			</div>

			<div class="col-lg-12"> 
				<input class="btn btn-primary" type="submit" value="Submit">
			</div>

		</form>

	</div>
@stop