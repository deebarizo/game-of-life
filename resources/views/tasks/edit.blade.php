@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		<form method="POST" action="/tasks/{{ $task->id }}" accept-charset="UTF-8">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">

			<div class="col-lg-12"> 
				<div class="form-group">
					<label for="name">Name:</label>
						<input style="width: 50%" class="form-control" name="name" type="text" value="{{ $task->name }}" id="name">
				</div>
			</div>

			<div class="col-lg-6"> 

				<?php 

					$checked['yes'] = ($task->is_in_history ? 'checked="checked"' : '');
					$checked['no'] = ($task->is_in_history ? '' : 'checked="checked"');

				?>

				<div class="form-group">
					<label for="name">Show In History:</label><br>
					<label class="radio-inline"><input type="radio" name="is_in_history" value="1" {{ $checked['yes'] }}>Yes</label>
					<label class="radio-inline"><input type="radio" name="is_in_history" value="0" {{ $checked['no'] }}>No</label>
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