<!doctype html>

<html lang="en">

	<head>
		<meta charset="UTF-8">

		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="/css/jquery.qtip.min.css">

		<script src="/js/jquery-1.11.3.min.js"></script>
		<script src="/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/jquery.dataTables.min.js"></script>
		<script src="/js/jquery.qtip.min.js"></script>
		<script src="/js/highcharts.js"></script>

		<?php $siteName = 'Game of Life'; ?>

		<title>{{ $h2Tag.' | ' }}{{ $siteName }}</title>
	</head>

	<body>
		<div class="navbar navbar-inverse" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="/">{{ $siteName }}</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="{!! setActive('daily_tasks*') !!}"><a href="/daily_tasks">Daily Tasks</a></li>
						<li class="{!! setActive('sitemap*') !!}"><a href="/sitemap">Sitemap</a></li>
					</ul>
				</div>
			</div>
	    </div>

		<div class="container">
			@yield('content')
		</div>
	</body>

</html>