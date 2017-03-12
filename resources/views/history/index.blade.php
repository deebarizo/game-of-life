@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		@foreach ($instances as $date => $mergedDailyInstances) 

			<div class="col-lg-12">

				<div class="panel panel-success">
				  
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

									<?php $star = (isset($mergedDailyInstance['is_in_history']) ? '' : '<img src="'.url('/files/icons/star.png').'">'); ?>

									<tr>
										<td>{{ $mergedDailyInstance['name'] }} {!! $star !!}</td>
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