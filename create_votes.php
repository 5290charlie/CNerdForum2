<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

$pid = 1;

$post = new CN_Post( $pid );

$newVote = array(
	'user_id' 	=> $user->id,
	'post_id' 	=> $post->id,
	'value' 	=> CN_VOTE_UP
);

if ( CN_Vote::votePost( $newVote ) )
	echo 'Voted on post: ' . $post->title;
else
	echo 'Failed voting on post: ' . $post->title;
	
echo '<br />';

$cid = 1;

$comment = new CN_Comment( $cid );

$newVote = array(
	'user_id' 		=> $user->id,
	'comment_id' 	=> $comment->id,
	'value' 		=> CN_VOTE_UP
);

if ( CN_Vote::voteComment( $newVote ) )
	echo 'Voted on comment!';
else
	echo 'Failed voting on comment!';
	
?>