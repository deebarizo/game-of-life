@extends('master')

@section('content')
	
	@include('_form_heading')

	<div class="row">

		@foreach ($tasks as $task) 

			<div class="col-lg-12">

				<div class="panel panel-success">
				  
				  	<div class="panel-heading">{{ $date }}</div>

						<table class="table">

							<thead>
								<tr>
									<th style="width: 60%">Name</th> 
									<th style="width: 40%">Date/Time</th> 
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

			</div>

		@endforeach

	</div>
@stop