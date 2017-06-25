<!doctype html>

<html lang="en">

	<head>
		<meta charset="UTF-8">

		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="/css/jquery.qtip.min.css">
		<link rel="stylesheet" href="/css/style.css">

		<script src="/js/jquery-1.11.3.min.js"></script>
		<script src="/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/jquery.dataTables.min.js"></script>
		<script src="/js/jquery.qtip.min.js"></script>
		<script src="/js/highcharts.js"></script>

		<?php $siteName = 'Game of Life'; ?>

		<?php $h2Tag = ($h2Tag == '' ? '' : $h2Tag.' | '); ?>

		<title>{{ $h2Tag }}{{ $siteName }}</title>
	</head>

	<body>
		<div class="navbar navbar-inverse" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a style="cursor:not-allowed;" class="navbar-brand" href="#">{{ $siteName }}</a>
				</div>
			</div>
	    </div>

		<div class="container">
			@yield('content')
		</div>

		@include('icons_credit')
	</body>



</html>