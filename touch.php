<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if( isset( $_GET['pid'] ) ) {
	$post = new CN_Post( $_GET['pid'] );
	if ($post->touch() ) {
		$cn->enqueueMessage(
			'Post: ' . $post->title . ' touched!',
			CN_MSG_SUCCESS,
			$_SESSION['sessionID']
		);
	} else {
		$cn->enqueueMessage(
			'Error attempting to touch post: ' . $post->title,
			CN_MSG_ERROR,
			$_SESSION['sessionID']
		);
	}
}

if( isset( $_GET['tid'] ) ) {
	$topic = new CN_Topic( $_GET['tid'] );
	if ($topic->touch() ) {
		$cn->enqueueMessage(
			'Topic: ' . $topic->title . ' touched!',
			CN_MSG_SUCCESS,
			$_SESSION['sessionID']
		);
	} else {
		$cn->enqueueMessage(
			'Error attempting to touch topic: ' . $topic->title,
			CN_MSG_ERROR,
			$_SESSION['sessionID']
		);
	}
}

CN::redirect( CN_WEBROOTPAGE . 'topics' );

?>