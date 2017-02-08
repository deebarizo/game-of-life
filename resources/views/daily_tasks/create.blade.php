@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		<form method="POST" action="/events" accept-charset="UTF-8">
			{{ csrf_field() }}

			<div class="col-lg-6"> 
				<div class="form-group">
					<label for="name">Name:</label>
						<input class="form-control" name="name" type="text" value="" id="name">
				</div>
			</div>

			<div class="col-lg-9"> 
				<div class="form-group">
					<label for="link">Link:</label>
						<input class="form-control" name="link" type="text" value="" id="link">
				</div>
			</div>

			<div class="col-lg-9"> 
				<div class="form-group">
					<label for="image_url">Image URL:</label>
						<input class="form-control" name="image_url" type="text" value="" id="image_url">
				</div>
			</div>

			<div class="col-lg-12"> 
				<input class="btn btn-primary" type="submit" value="Submit">
			</div>

		</form>

	</div>
@stop