{{ csrf_field() }}

<div class="row">
	<div class="col-lg-3"> 
		<div class="form-group">
			<label for="name">Name:</label>
			<input class="form-control" name="name" type="text" value="{{ old('name', $badHabit->name) }}" id="name">
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-3"> 
		<div class="form-group">
			<label for="is_success">Is This a Successful Task?</label><br>
			<label class="radio-inline"><input type="radio" name="is_success" value="1" {{ (old('is_success', $badHabit->is_success) == 1) ? 'checked="checked"' : '' }}>Yes</label>
			<label class="radio-inline"><input type="radio" name="is_success" value="0" {{ (old('is_success', $badHabit->is_success) == 0) ? 'checked="checked"' : '' }}>No</label>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6"> 
		<div class="form-group">
			<label for="description">Description (Optional):</label>
			<input class="form-control" name="description" type="text" value="{{ old('description', $badHabit->description) }}" id="description">
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-3"> 
		<div class="form-group">
			<label for="image">Image (<a target="_blank" href="http://www.flaticon.com/">Link</a>):</label>
			<input name="image" type="file" id="image">
		</div>
	</div>

	@if ($badHabit->image_url)
		<div class="col-lg-4">
			<div>
				<h4>Current image</h4>
				<img src="{!! url($badHabit->image_url); !!}">
			</div>
		</div>
	@endif
</div>

<div class="row">
	<div class="col-lg-12" style="margin-top: 25px"> 
		<input class="btn btn-primary" type="submit" value="{{ $submitButtonText }}">
	</div>
</div>