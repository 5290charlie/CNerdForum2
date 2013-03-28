<?php

/*************************************************
			Logout Page
**************************************************
	Author: Charlie McClung
	Updated: 3/24/2013
		Logs current user/session out of the
		CNerdForum
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

// Log the current user out
$user->logout();

// Redirect to homepage
CN::redirect( CN_WEBROOTPAGE );

?>