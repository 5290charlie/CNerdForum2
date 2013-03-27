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

$cn =& CN::getInstance();
$cn->init();

$user->logout();

CN::redirect( CN_WEBROOTPAGE );

?>