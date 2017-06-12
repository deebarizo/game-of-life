{{ csrf_field() }}

<div class="col-lg-12"> 
	<div class="form-group">
		<label for="name">Name:</label>
		<input style="width: 50%" class="form-control" name="name" type="text" value="{{ old('name', $task->name) }}" id="name">
	</div>
</div>

<div class="col-lg-6"> 
	<div class="form-group">
		<label for="name">Show In History:</label><br>
		<label class="radio-inline"><input type="radio" name="is_in_history" value="1" {{ (old('is_in_history', $task->is_in_history) == 1) ? 'checked="checked"' : '' }}>Yes</label>
		<label class="radio-inline"><input type="radio" name="is_in_history" value="0" {{ (old('is_in_history', $task->is_in_history) == 0) ? 'checked="checked"' : '' }}>No</label>
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

<div class="col-lg-4"> 
	<div class="form-group">
		<label for="image">Image (<a target="_blank" href="http://www.flaticon.com/">Link</a>):</label>
		<input name="image" type="file" id="image">
	</div>
</div>

@if ($task->image_url)
	<div class="col-lg-4">
		<div>
			<h4>Current image</h4>
			<img src="{!! url($task->image_url); !!}">
		</div>
	</div>
@endif

<div class="col-lg-12" style="margin-top: 20px"> 
	<input class="btn btn-primary" type="submit" value="{{ $submitButtonText }}">
</div>