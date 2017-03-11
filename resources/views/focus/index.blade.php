@extends('master_focus')

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<h2>Focus Mode</h2>
			<hr>
		</div>
	</div>

	<div class="row">

		<?php 

			$isComplete = ($instance->is_complete ? 'complete' : '');
			$description = ($instance->description == '' ? '' : '<a class="description" href="#"><img src="'.url('/files/icons/text-lines.png').'"></a><div style="display: none" class="tool-tip-description">'.$instance->description.'</div>');
			$link = ($instance->link == '' ? '' : '<a target="_blank" href="'.$instance->link.'"><img src="'.url('/files/icons/link.png').'"></a>');
		
		?>

		<div class="col-lg-offset-4 col-lg-4">

			<div class="instance {{ $isComplete }}" style="height: 250px; border: 1px solid; margin-bottom: 30px; margin-top: 20px">
				<h4 class="text-center" style="margin: 18px 18px">{{ $instance->name }} {!! $description !!} {!! $link !!}</h4>

				<img class="center-block" style="margin-bottom: 27px" src="<?php echo url($instance->image_url); ?>">

				<div class="text-center"><a class="complete" href="#"><img src="<?php echo url('/files/icons/checked.png'); ?>"></a></div>
			</div>

		</div>

	</div>

@stop