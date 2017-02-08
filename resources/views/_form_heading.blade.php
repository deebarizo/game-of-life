<div class="row">
	<div class="col-lg-12">
		<h2>{{ $h2Tag }}</h2>

		<hr>

		@if (count($errors) > 0)
		    <div class="alert alert-danger fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		    	
		    	<p>Please try again.</p>

		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		@if (Session::has('message'))
			<div class="alert <?php echo (Session::get('message') === 'Success!' ? 'alert-info success-alert' : 'alert-danger'); ?> fade in success-message" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

				{!! Session::get('message') !!}
		    </div>
		@endif
	</div>

	<script type="text/javascript">
		
		// $("div.success-alert").fadeTo(1000, 500).slideUp(500, function(){
		    
		    // $("div.success-alert").alert('close');
		// });

	</script>
</div>