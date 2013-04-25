<?php

/*************************************************
			Voting Post AJAX Page
**************************************************
	Author: Charlie McClung
	Updated: 4/2/2013
		Create new post vote and reload data
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

if ( !empty( $_POST ) && !empty( $_POST['post_id'] ) && !empty( $_POST['value'] ) ) {	
	$post = new CN_Post( $_POST['post_id'] );
	
	$newVote = array(
		'user_id' 	=> $user->id,
		'post_id' 	=> $post->id,
		'value' 	=> $_POST['value']
	);
	
	if ( CN_Vote::votePost( $newVote ) ) {
	
		$posts = $post->topic->getPosts();
		
		require_once CN_DIR_AJAX . 'topic.php';
		
	} else { echo 'Error voting!'; }
}?>