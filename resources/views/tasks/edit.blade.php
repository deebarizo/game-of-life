@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		<form method="POST" action="/tasks/{{ $task->id }}" accept-charset="UTF-8">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">

			<div class="col-lg-6"> 
				<div class="form-group">
					<label for="name">Name:</label>
						<input class="form-control" name="name" type="text" value="{{ old('name', $task->name) }}" id="name">
				</div>
			</div>

			<div class="col-lg-9"> 
				<div class="form-group">
					<label for="description">Description (Optional):</label>
						<input class="form-control" name="description" type="text" value="{{ old('description', $task->description) }}" id="description">
				</div>
			</div>

			<div class="col-lg-9"> 
				<div class="form-group">
					<label for="link">Link (Optional):</label>
						<input class="form-control" name="link" type="text" value="{{ old('link', $task->link) }}" id="link">
				</div>
			</div>

			<div class="col-lg-12"> 
				<input class="btn btn-primary" type="submit" value="Submit">
			</div>

		</form>

	</div>
@stop