@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		@foreach ($tasks as $date => $dailyTasks) 

			<div class="col-lg-12">

				<div class="panel panel-success">
				  
				  	<div class="panel-heading">{{ $date }}</div>

					<table class="table">

						<thead>
							<tr>
								<th style="width: 60%">Name</th> 
								<th style="width: 40%">Completed At</th> 
							</tr> 
						</thead> 

						<tbody> 
							@if (count($dailyTasks) > 0)
								@foreach ($dailyTasks as $dailyTask)
									<tr>
										<td><a href="{{ $dailyTask->path().'/edit' }}">{{ $dailyTask->name }}</a> {!! ($dailyTask->is_in_history ? '<img src="'.url('/files/icons/star.png').'">' : '') !!}</td>
										<td>{{ $dailyTask->completed_at }}</td>
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
@stop