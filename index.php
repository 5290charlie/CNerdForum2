<?php

/*************************************************
			Index Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		CNerdForum Homepage
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<h1>Homepage</h1>
				<br />
				<a class="button" href="<?php echo CN_WEBROOTPAGE . 'topics'; ?>">View Topics</a>
				<br />
				<p>More coming soon!</p>
<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>