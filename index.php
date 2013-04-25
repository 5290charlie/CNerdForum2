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
  					<div id="tab-home" class="tab-content">
				        <?php require_once CN_DIR_AJAX . 'index.php'; ?>
				    </div>
				    <div id="tab-topics" class="tab-content">
						<?php require_once CN_DIR_AJAX . 'topics.php'; ?>
				    </div>
<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>