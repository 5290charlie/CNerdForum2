<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"><!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Selectize.js Demo</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		<link rel="stylesheet" href="/css/_normalize.css">
		<link rel="stylesheet" href="/css/_stylesheet.css">
		<link rel="stylesheet" href="/css/selectize.css">
		<!--[if IE 8]><script src="/scripts/_es5.js"></script><![endif]-->
		<script src="/scripts/jquery-1.9.1.js"></script>
		<script src="/scripts/selectize.js"></script>
		
		<style type="text/css">
		.selectize-control.repositories .selectize-dropdown > div {
			border-bottom: 1px solid rgba(0,0,0,0.05);
		}
		.selectize-control.repositories .selectize-dropdown .by {
			font-size: 11px;
			opacity: 0.8;
		}
		.selectize-control.repositories .selectize-dropdown .by::before {
			content: 'by ';
		}
		.selectize-control.repositories .selectize-dropdown .name {
			font-weight: bold;
			margin-right: 5px;
		}
		.selectize-control.repositories .selectize-dropdown .title {
			display: block;
		}
		.selectize-control.repositories .selectize-dropdown .description {
			font-size: 12px;
			display: block;
			color: #a0a0a0;
			white-space: nowrap;
			width: 100%;
			text-overflow: ellipsis;
			overflow: hidden;
		}
		.selectize-control.repositories .selectize-dropdown .meta {
			list-style: none;
			margin: 0;
			padding: 0;
			font-size: 10px;
		}
		.selectize-control.repositories .selectize-dropdown .meta li {
			margin: 0;
			padding: 0;
			display: inline;
			margin-right: 10px;
		}
		.selectize-control.repositories .selectize-dropdown .meta li span {
			font-weight: bold;
		}
		.selectize-control.repositories::before {
			-moz-transition: opacity 0.2s;
			-webkit-transition: opacity 0.2s;
			transition: opacity 0.2s;
			content: ' ';
			z-index: 2;
			position: absolute;
			display: block;
			top: 12px;
			right: 34px;
			width: 16px;
			height: 16px;
			background: url(/images/spinner.gif);
			background-size: 16px 16px;
			opacity: 0;
		}
		.selectize-control.repositories.loading::before {
			opacity: 0.4;
		}
		</style>
	</head>
    <body>
		<div id="wrapper">
			<h1>Search with Selectize.js</h1>
			<div class="demo">
				<h2>Search Stuff</h2>
				<p>Search JSON API.</p>
				<div class="control-group">
					<label for="select-search">Search:</label>
					<select id="select-search" placeholder="Search Something..."></select>
				</div>
				<script>
				$('#select-search').selectize({
					theme: 'repositories',
					persist: true,
					maxItems: 1,
					valueField: 'link',
					labelField: 'title',
					searchField: ['title', 'details', 'authorStr'],
					options: [],
					render: {
						option: function(item) {
							return '<div>' +
								'<span class="title">' +
									'<span class="name">' + item.title + '</span>' +
									'<span class="by">' + item.authorStr + '</span>' +
								'</span>' +
								'<span class="description">' + item.details + '</span>' +
							'</div>';
						}
					},
					create: false,
					load: function(query, callback) {
						if (!query.length) return callback();
						$.ajax({
							url: 'http://cnerdforum.local.devserver/ajax/api.php',
							type: 'GET',
							dataType: 'jsonp',
							data: {
								q: query,
							},
							error: function() {
								callback();
							},
							success: function(res) {
								callback(res);
							}
						});
					},
					onChange: function() {
						if ($('#select-search').val() != '') {
							window.location = $('#select-search').val();
						}
					}
				});
				</script>
			</div>
		</div>
	</body>
</html>