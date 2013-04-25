<?php

/*************************************************
			Topics Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		Displays All Topics
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<h2>Users</h2>
				<?php require_once CN_DIR_AJAX . 'users.php'; ?>

<input type="hidden" id="page" name="page" value="admin" />
<input type="hidden" id="page-title" name="page-title" value="Admin Panel" />

<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>