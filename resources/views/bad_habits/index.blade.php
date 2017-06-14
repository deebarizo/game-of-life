@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		@foreach ($badHabitsGroupedByDate as $date => $badHabits) 

			<div class="col-lg-12">

				<div class="panel panel-success">
				  
				  	<div class="panel-heading">{{ $date }}</div>

					<table class="table">

						<thead>
							<tr>
								<th style="width: 60%">Name</th> 
								<th style="width: 40%">Description</th> 
							</tr> 
						</thead> 

						<tbody> 
							@if (count($badHabits) > 0)
								@foreach ($badHabits as $badHabit)
									<tr>
										<td><a style="{!! $badHabit->is_success_html() !!}" href="{{ $badHabit->path().'/edit' }}">{{ $badHabit->name }}</a></td>
										<td>{{ $badHabit->description }}</td>
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