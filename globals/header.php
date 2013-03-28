<?php

/*************************************************
			Global Header
**************************************************
	Author: Charlie McClung
	Updated: 3/23/2013
		Included at the top of every page
*************************************************/

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );
?>
<!DOCTYPE HTML>
<!-- **************************
	Built by: Charlie McClung
	Last Updated: 3/23/2013
*************************** -->
<html>
	
	<?php // Begin HTML head tag ?>
	<head>
	
		<?php // Basic header setup ?>
		<title>CNerdforum [a place for nerds]</title>
		<meta charset="utf-8">
		
		<?php // Link to favicon file ?>
		<link rel="shortcut icon" href="<?php echo CN_WEBDIR_IMAGES; ?>icons/favicon.ico" />
		
		<?php // Link all CSS, LESS, and/or JS files needed ?>
		<link href='http://fonts.googleapis.com/css?family=Sintony:400,700' rel='stylesheet' type='text/css'>
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
			
				<?php // Begin HTML userdata div ?>	
				<div id="userdata">
					<?php if ( isset( $user ) && $user->isOnline() ) {
						echo 'Welcome, ' . $user->username; ?>
						<a href="<?php echo CN_WEBLOGOUT; ?>" class="button">Logout</a>
					<?php } ?>
				</div>
				<hgroup>
					<h1><a href="<?php echo CN_WEBROOTPAGE; ?>">CNerdForum</a></h1>
					<h2>[a place for nerds]</h2>
				</hgroup>
			</header>
			<?php // Begin HTML content div ?>	
			<div id="content">
			
				<?php // Begin HTML messages div ?>	
				<div id="messages">
					<?php require_once( CN_DIR_GLOBALS . 'getMessages.php' ); ?>
				</div>
				<?php if ( isset( $user ) && $user->isOnline() ) { ?>
				
					<?php // Begin HTML breadcrumbs div ?>	
					<div id="breadcrumbs">
						<?php require_once( CN_DIR_GLOBALS . 'breadCrumbs.php' ); ?>
					</div>
				<?php } ?>
				
				<?php // Begin HTML main div ?>	
				<div id="main">