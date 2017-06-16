<div class="task {{ ($task->is_complete ? 'complete' : '') }}" style="height: 250px; border: 1px solid; margin-bottom: 30px" data-task-id="{{ $task->id }}">
	<h4 class="text-center" style="margin: 18px 18px">{{ $task->name }} @include('tasks.task_icons')</h4>

	<img class="center-block" style="margin-bottom: 27px" src="<?php echo url('/files/images/'.$task->image->filename); ?>">

	<div class="text-center">
		@if ($hasFocusIcon)
			<a href="{{ $task->path().'/focus' }}"><img src="<?php echo url('/files/icons/target.png'); ?>"></a> 
		@endif
		<a href="/tasks/{{ $task->id }}/edit"><img src="<?php echo url('/files/icons/edit.png'); ?>"></a> 
		<a class="complete" href="#"><img src="<?php echo url('/files/icons/checked.png'); ?>"></a> 
		<form style="display: inline" method="POST" action="{{ $task->path() }}" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE">{{ csrf_field() }}
			<button class="delete" type="submit"><img src="/files/icons/trash.png"></button>
		</form> 
		<span style="margin-left: 200px">{{ $task->order }}</span>
	</div>
</div>