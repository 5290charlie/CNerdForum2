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
		
		<style type="text/css">
body
{
    width: 700px;
    margin: 100px auto 0 auto;
    font-family: Arial, Helvetica;
    font-size: small;
	background: #444;
}

/* ------------------------------------------------- */

#tabs{
  overflow: hidden;
  width: 100%;
  margin: 0;
  padding: 0;
  list-style: none;
}

#tabs li{
  float: left;
  margin: 0 .5em 0 0;
}

#tabs a{
  position: relative;
  background: #ddd;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#ddd));
  background-image: -webkit-linear-gradient(top, #fff, #ddd);
  background-image: -moz-linear-gradient(top, #fff, #ddd);
  background-image: -ms-linear-gradient(top, #fff, #ddd);
  background-image: -o-linear-gradient(top, #fff, #ddd);
  background-image: linear-gradient(to bottom, #fff, #ddd);  
  padding: .7em 3.5em;
  float: left;
  text-decoration: none;
  color: #444;
  text-shadow: 0 1px 0 rgba(255,255,255,.8);
  -webkit-border-radius: 5px 0 0 0;
  -moz-border-radius: 5px 0 0 0;
  border-radius: 5px 0 0 0;
  -moz-box-shadow: 0 2px 2px rgba(0,0,0,.4);
  -webkit-box-shadow: 0 2px 2px rgba(0,0,0,.4);
  box-shadow: 0 2px 2px rgba(0,0,0,.4);
}

#tabs a:hover,
#tabs a:hover::after,
#tabs a:focus,
#tabs a:focus::after{
  background: #fff;
}

#tabs a:focus{
  outline: 0;
}

#tabs a::after{
  content:'';
  position:absolute;
  z-index: 1;
  top: 0;
  right: -.5em;  
  bottom: 0;
  width: 1em;
  background: #ddd;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#ddd));
  background-image: -webkit-linear-gradient(top, #fff, #ddd);
  background-image: -moz-linear-gradient(top, #fff, #ddd);
  background-image: -ms-linear-gradient(top, #fff, #ddd);
  background-image: -o-linear-gradient(top, #fff, #ddd);
  background-image: linear-gradient(to bottom, #fff, #ddd);  
  -moz-box-shadow: 2px 2px 2px rgba(0,0,0,.4);
  -webkit-box-shadow: 2px 2px 2px rgba(0,0,0,.4);
  box-shadow: 2px 2px 2px rgba(0,0,0,.4);
  -webkit-transform: skew(10deg);
  -moz-transform: skew(10deg);
  -ms-transform: skew(10deg);
  -o-transform: skew(10deg);
  transform: skew(10deg);
  -webkit-border-radius: 0 5px 0 0;
  -moz-border-radius: 0 5px 0 0;
  border-radius: 0 5px 0 0;  
}

#tabs #current a{
  background: #fff;
  z-index: 3;
}

#tabs #current a::after{
  background: #fff;
  z-index: 3;
}

/* ------------------------------------------------- */

#content
{
    background: #fff;
	position: relative;
	z-index: 2;	
}

#content h2, #content h3, #content p
{
    margin: 0 0 15px 0;
}

/* ------------------------------------------------- */

#about
{
    color: #999;
}

#about a
{
    color: #eee;
}

</style>
		
		<?php // Link all CSS, LESS, and/or JS files needed ?>
		<link href='http://fonts.googleapis.com/css?family=Sintony:400,700' rel='stylesheet' type='text/css'>
		<link href="<?php echo CN_WEBDIR_CSS; ?>updated.less" rel="stylesheet/less" type="text/css" />
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
		
			<div id="userstatus">
				<?php require_once CN_DIR_AJAX . 'userstatus.php'; ?>
			</div>
		    <div id="header">
		        <hgroup>
					<h1><a href="<?php echo CN_WEBROOTPAGE; ?>">CNerdForum</a></h1>
					<h2>[a place for nerds]</h2>
				</hgroup>
		    </div>
		    
			<ul id="tabs">
			    <li><a href="#" name="tab-home">Home</a></li>
			    <li><a href="#" name="tab-topics">Topics</a></li>  
			</ul>

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
								
				
