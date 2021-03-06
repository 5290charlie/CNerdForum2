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
		<link href="<?php echo CN_WEBDIR_CSS; ?>updated.less" rel="stylesheet/less" type="text/css" />
		<link href="<?php echo CN_WEBDIR_CSS; ?>jquery-ui-1.10.2.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo CN_WEBDIR_CSS; ?>selectize.css" rel="stylesheet" type="text/css" />
		
		<!--[if IE 8]><script src="<?php echo CN_WEBDIR_SCRIPTS; ?>_es5.js"></script><![endif]-->
		<script src="<?php echo CN_WEBDIR_SCRIPTS; ?>jquery-1.9.1.js" type="text/javascript"></script>
		<script src="<?php echo CN_WEBDIR_SCRIPTS; ?>jquery-ui-1.10.2.js" type="text/javascript"></script>
		<script src="<?php echo CN_WEBDIR_SCRIPTS; ?>functions.js" type="text/javascript"></script>
		<script src="<?php echo CN_WEBDIR_SCRIPTS; ?>less-1.3.3.js" type="text/javascript"></script>
		<script src="<?php echo CN_WEBDIR_SCRIPTS; ?>selectize.js" type="text/javascript"></script>
		
	</head>
	
	<?php // Begin HTML body tag ?>	
	<body>
		<div id="status_bar">
			<div id="status_container">
				<div id="userstatus">
					<?php require_once CN_DIR_AJAX . 'userstatus.php'; ?>
				</div>
				<div class="control-group">
					<select id="select-search" placeholder="Search CNerdForum..."></select>
				</div>
			</div>
		</div>
		
		<?php // Begin DIV #container ?>	
		<div id="container">
		    <div id="header">
		        
		        <div class="hgroup">
					<h1><a href="<?php echo CN_WEBROOTPAGE; ?>">CNerdForum</a></h1>
					<h2>[a place for nerds]</h2>
				</div>
				
		    </div>
		    
			<ul id="tabs">
			    <li id="tab-home"><a href="<?php echo CN_WEBROOTPAGE; ?>" name="tab-home">Home</a></li>
			    <li id="tab-topics"><a href="<?php echo CN_WEBROOTPAGE . 'topics'; ?>" name="tab-topics">Topics</a></li>  
			    <li id="tab-account"><a href="<?php echo CN_WEBACCOUNT; ?>" name="tab-account">Account</a></li>  
			<?php if ( isset( $user ) && $user->isAdmin() ) { ?>
			    <li id="tab-admin"><a href="<?php echo CN_WEBROOTPAGE . 'admin'; ?>" name="tab-admin">Admin</a></li>  
			<?php } ?>
			</ul>

			<?php // Begin HTML content div ?>	
			<div id="content">
			
				<?php // Begin HTML messages div ?>	
				<div id="messages">
					<?php require_once( CN_DIR_GLOBALS . 'getMessages.php' ); ?>
				</div>
								
				
