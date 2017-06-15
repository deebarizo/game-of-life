@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		<div class="col-lg-12">

			<p style="margin-bottom: 20px"><a href="/tasks/create">Create Task</a></p>

		</div>

		@foreach ($tasksGroupedByDate as $date => $tasks) 

			<div class="col-lg-12">

				<div class="panel panel-success">
				  
				  	<div class="panel-heading">{{ $date }}</div>

					<table class="table">

						<thead>
							<tr>
								<th style="width: 60%">Name</th> 
								<th style="width: 40%">Order</th> 
							</tr> 
						</thead> 

						<tbody> 
							@if (count($tasks) > 0)
								@foreach ($tasks as $task)
									<tr>
										<td><a style="{!! $task->is_complete_html() !!}" href="{{ $task->path().'/edit' }}">{{ $task->name }}</a> @include('tasks.task_icons')</td>
										<td>{{ $task->order }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>								
							@endif
						</tbody>

					</table>

				</div>
					
			</div>

		@endforeach

	</div>

	@include('tasks.js')
@stop