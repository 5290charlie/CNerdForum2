<?php

/*************************************************
			Logout Page
**************************************************
			Author: Charlie McClung
			Updated: 3/24/2013
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

$user->logout();

CN::redirect( CN_WEBROOTPAGE );

?>