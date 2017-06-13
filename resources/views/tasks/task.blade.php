<?php 
	$description = ($task->description == '' ? '' : '<a class="description" href="#"><img src="'.url('/files/icons/text-lines.png').'"></a><div style="display: none" class="tool-tip-description">'.$task->description.'</div>');
	$link = ($task->link == '' ? '' : '<a target="_blank" href="'.$task->link.'"><img src="'.url('/files/icons/link.png').'"></a>');
	$star = ($task->is_in_history ===  1 ? '<img src="'.url('/files/icons/star.png').'">' : '');
?>

<div class="task {{ ($task->is_complete ? 'complete' : '') }}" style="height: 250px; border: 1px solid; margin-bottom: 30px" data-task-id="{{ $task->id }}">
	<h4 class="text-center" style="margin: 18px 18px">{{ $task->name }} {!! $description !!} {!! $link !!} {!! $star !!}</h4>

	<img class="center-block" style="margin-bottom: 27px" src="<?php echo url($task->image_url); ?>">

	<div class="text-center"><a href="{{ $task->path().'/focus' }}"><img src="<?php echo url('/files/icons/target.png'); ?>"></a> <a href="/tasks/{{ $task->id }}/edit"><img src="<?php echo url('/files/icons/edit.png'); ?>"></a> <a class="complete" href="#"><img src="<?php echo url('/files/icons/checked.png'); ?>"></a> <form style="display: inline" method="POST" action="{{ $task->path() }}" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE">{{ csrf_field() }}<button class="delete" type="submit"><img src="/files/icons/trash.png"></button></form></div>
</div>