@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		<form method="POST" action="/daily_tasks/{{ $dailyTask->id }}" accept-charset="UTF-8">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">

			<div class="col-lg-6"> 
				<div class="form-group">
					<label for="name">Name:</label>
						<input class="form-control" name="name" type="text" value="{{ $dailyTask->name }}" id="name">
				</div>
			</div>

			<div class="col-lg-9"> 
				<div class="form-group">
					<label for="description">Description (Optional):</label>
						<input class="form-control" name="description" type="text" value="{{ $dailyTask->description }}" id="description">
				</div>
			</div>

			<div class="col-lg-9"> 
				<div class="form-group">
					<label for="link">Link (Optional):</label>
						<input class="form-control" name="link" type="text" value="{{ $dailyTask->link }}" id="link">
				</div>
			</div>

			<div class="col-lg-12"> 
				<input class="btn btn-primary" type="submit" value="Submit">
			</div>

		</form>

	</div>
@stop