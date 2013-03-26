<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if( !empty( $_POST ) && !empty( $_POST['topic_id'] ) && !empty( $_POST['user_id'] ) && !empty( $_POST['title'] ) && !empty( $_POST['details'] ) ) {
	if ( CN_Post::add( $_POST ) ) {
		$cn->enqueueMessage(
			'Successfully created post: ' . $_POST['title'],
			CN_MSG_SUCCESS,
			$_SESSION['sessionID']
		);
	} else {
		$cn->enqueueMessage(
			'Error creating post: ' . $_POST['title'],
			CN_MSG_ERROR,
			$_SESSION['sessionID']
		);
	}
	
	CN::redirect( CN_WEBROOTPAGE . 'topic?tid=' . $_POST['topic_id'] );
} 

if( !empty( $_GET ) && !empty( $_GET['tid'] ) ) {
	$topic = new CN_Topic( $_GET['tid'] );
	
	// Require header global
	require_once( CN_DIR_GLOBALS . 'header.php' );
	?>
			Post	
	<?
	// Require footer global
	require_once( CN_DIR_GLOBALS . 'footer.php' );
} else {
	$cn->enqueueMessage((
		'MUST provide topic_id (tid) to view topic!',
		CN_MSG_ERROR,
		$_SESSION['sessionID']
	);
	
	CN::redirect( CN_WEBROOTPAGE . 'topics' );
}
?>