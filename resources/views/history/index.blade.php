@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		@foreach ($instances as $date => $mergedDailyInstances) 

			<div class="col-lg-12">

				<div class="panel panel-info">
				  
				  	<div class="panel-heading">{{ $date }}</div>

						<table class="table">

							<thead>
								<tr>
									<th>Name</th> 
									<th>Date/Time</th> 
								</tr> 
							</thead> 

							<tbody> 

								@foreach ($mergedDailyInstances as $mergedDailyInstance)

									<tr>
										<td>{{ $mergedDailyInstance['name'] }}</td>
										<td>{{ $mergedDailyInstance['completed_at'] }}</td>
									</tr>

								@endforeach

							</tbody>

						</table>
					
				</div>

			</div>

		@endforeach

	</div>
@stop