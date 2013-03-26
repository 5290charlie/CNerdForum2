<?php
// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );
?>
<!DOCTYPE HTML>
<!-- **************************
	Built by: Charlie McClung
	Last Updated: 3/23/2013
*************************** -->
<html>
	
	<?php // Begin HTML head tag
	echo 'SESSION: ' . print_r($_SESSION) . '<br />';
	$cn =& CN::getInstance();
	echo 'MESSAGES: ' . print_r($cn->getMessages()) . '<br />';
	?>
	<head>
	
		<?php // Basic header setup ?>
		<title>CNerdforum [a place for nerds]</title>
		<meta charset="utf-8">
		
		<?php // Link to favicon file ?>
		<link rel="shortcut icon" href="<?php echo CN_WEBDIR_IMAGES; ?>icons/favicon.ico" />
		
		<?php // Link all CSS, LESS, and/or JS files needed ?>
		<link href='http://fonts.googleapis.com/css?family=Rufina:400,700' rel='stylesheet' type='text/css'>
		<link href="<?php echo CN_WEBDIR_CSS; ?>style.less" rel="stylesheet/less" type="text/css" />
		<link href="<?php echo CN_WEBDIR_CSS; ?>jquery-ui-1.10.2.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo CN_WEBDIR_SCRIPTS; ?>jquery-1.9.1.js" type="text/javascript"></script>
		<script src="<?php echo CN_WEBDIR_SCRIPTS; ?>jquery-ui-1.10.2.js" type="text/javascript"></script>
		<script src="<?php echo CN_WEBDIR_SCRIPTS; ?>functions.js" type="text/javascript"></script>
		<script src="<?php echo CN_WEBDIR_SCRIPTS; ?>less-1.3.3.js" type="text/javascript"></script>
	</head>
	
	<?php // Begin HTML body tag ?>	
	<body>

		<?php // Begin DIV #container ?>	
		<div id="container">
		
			<?php // Begin HTML header tag ?>	
			<header id="header">
				<div id="userdata">
					<a href="<?php echo CN_WEBLOGIN; ?>" class="button">Login</a>
					OR
					<a href="<?php echo CN_WEBSIGNUP; ?>" class="button">Sign Up!</a>
				</div>
				<hgroup>
					<h1><a href="<?php echo CN_WEBROOTPAGE; ?>">CNerdForum</a></h1>
					<h2>[a place for nerds]</h2>
				</hgroup>
			</header>
			<div id="content">