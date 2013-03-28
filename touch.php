<?php

/*************************************************
			Touch Page
**************************************************
	Author: Charlie McClung
	Updated: 3/25/2013
		Tests Topic or Post touch() method with
		either tid or pid as GET parameter
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

// If GET parameter "pid" specified, update the post
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
	
	// Redirect back to topic page containing this post
	CN::redirect( CN_WEBROOTPAGE . 'topic?tid=' . $post->topic->id );
}

// If GET parameter "tid" specified, update the topic
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

	// Redirect back to topics page
	CN::redirect( CN_WEBROOTPAGE . 'topics' );
}
?>