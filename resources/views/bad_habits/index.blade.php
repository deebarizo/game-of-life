@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		<div class="col-lg-12">

			<p style="margin-bottom: 20px"><a href="/bad_habits/create">Create Bad Habit</a></p>

		</div>

		@foreach ($badHabitsGroupedByDate as $date => $badHabits) 

			<div class="col-lg-12">

				<div class="panel panel-success">
				  
				  	<div class="panel-heading">{{ $date }}</div>

					<table class="table">

						<thead>
							<tr>
								<th style="width: 40%">Name</th> 
								<th style="width: 40%">Description</th> 
								<th style="width: 20%">Delete</th> 
							</tr> 
						</thead> 

						<tbody> 
							@if (count($badHabits) > 0)
								@foreach ($badHabits as $badHabit)
									<tr>
										<td><a style="{!! $badHabit->is_success_html() !!}" href="{{ $badHabit->path().'/edit' }}">{{ $badHabit->name }}</a></td>
										<td>{{ $badHabit->description }}</td>
										<td><form style="display: inline" method="POST" action="{{ $badHabit->path() }}" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE">{{ csrf_field() }}<button class="delete" type="submit"><img src="/files/icons/trash.png"></button></form></td>
									</tr>
								@endforeach
							@else
								<tr>
									<td>&nbsp;</td>
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