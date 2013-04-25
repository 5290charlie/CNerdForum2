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
    padding: 2em;
	height: 220px;
	position: relative;
	z-index: 2;	
    -moz-border-radius: 0 5px 5px 5px;
    -webkit-border-radius: 0 5px 5px 5px;
    border-radius: 0 5px 5px 5px;
    -moz-box-shadow: 0 -2px 3px -2px rgba(0, 0, 0, .5);
    -webkit-box-shadow: 0 -2px 3px -2px rgba(0, 0, 0, .5);
    box-shadow: 0 -2px 3px -2px rgba(0, 0, 0, .5);
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
			    <li><a href="#" name="tab1">Home</a></li>
			    <li><a href="#" name="tab2">Topics</a></li>
			    <li><a href="#" name="tab3">Three</a></li>
			    <li><a href="#" name="tab4">Four</a></li>    
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
				
				    <div id="tab1">
				        <h2>Lorem ipsum sit amet</h2>
				        <p>Praesent risus nisi, iaculis nec condimentum vel, rhoncus vel dolor. Aenean nisi lectus, varius nec tempus id, dapibus non quam.</p>
				        <p>Suspendisse ac libero mauris. Cras lacinia porttitor urna, vitae molestie libero posuere et. Mauris turpis tortor, mollis non vulputate sit amet, rhoncus vitae purus.</p>
				
				        <h3>Pellentesque habitant</h3>
				        <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.</p>    
				    </div>
				    <div id="tab2">
				        <h2>Vivamus fringilla suscipit justo</h2>
				        <p>Aenean dui nulla, egestas sit amet auctor vitae, facilisis id odio. Donec dictum gravida feugiat.</p>
				        <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras pretium elit et erat condimentum et volutpat lorem vehicula</p>
				
				        <p>Morbi tincidunt pharetra orci commodo molestie. Praesent ut leo nec dolor tempor eleifend.</p>    
				    </div>
				    <div id="tab3">
				        <h2>Phasellus non nibh</h2>
				        <p>Non erat laoreet ullamcorper. Pellentesque magna metus, feugiat eu elementum sit amet, cursus sed diam. Curabitur posuere porttitor lorem, eu malesuada tortor faucibus sed.</p>
				        <h3>Duis pulvinar nibh vel urna</h3>
				        <p>Donec purus leo, porttitor eu molestie quis, porttitor sit amet ipsum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec accumsan ornare elit id imperdiet. </p>
				
				        <p>Suspendisse ac libero mauris. Cras lacinia porttitor urna, vitae molestie libero posuere et. </p>
				    </div>
				    <div id="tab4">
				        <h2>Cum sociis natoque penatibus</h2>
				        <p>Magnis dis parturient montes, nascetur ridiculus mus. Nullam ac massa quis nisi porta mollis venenatis sit amet urna. Ut in mauris velit, sed bibendum turpis.</p>
				        <p>Nam ornare vulputate risus, id volutpat elit porttitor non. In consequat nisi vel lectus dapibus sodales. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent bibendum sagittis libero.</p>
				        <h3>Imperdiet sem interdum nec</h3>
				
				        <p>Mauris rhoncus tincidunt libero quis fringilla.</p>    
				    </div>
				</div>
								
				
