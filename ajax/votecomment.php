<?php

/*************************************************
			Comment Voting AJAX Page
**************************************************
	Author: Charlie McClung
	Updated: 4/2/2013
		Create new comment vote and reload data
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

if ( !empty( $_POST ) && !empty( $_POST['comment_id'] ) && !empty( $_POST['value'] ) ) {
	$comment = new CN_Comment( $_POST['comment_id'] );
	
	$newVote = array(
		'user_id' 		=> $user->id,
		'comment_id' 	=> $_POST['comment_id'],
		'value' 		=> $_POST['value']
	);
	
	if (CN_Vote::voteComment( $newVote )) {	
		$comments = $comment->post->getComments();
		
		require_once CN_DIR_AJAX . 'post.php';
	} else { echo 'Error voting!'; }
} ?>