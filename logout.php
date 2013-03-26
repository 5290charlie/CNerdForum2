<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if ( $user->logout() ) {
	$cn->enqueueMessage(
		'You have been successfully logged out.',
		CN_MSG_SUCCESS,
		$_SESSION['sessionID']
	);
} else {
	$cn->enqueueMessage(
		'There was an error logging you out.',
		CN_MSG_ERROR,
		$_SESSION['sessionID']
	);
}
CN::redirect( CN_WEBROOTPAGE );

?>