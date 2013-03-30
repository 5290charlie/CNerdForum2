<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

$pid = 1;

$post = new CN_Post( $pid )

$newVote = array(
	'user_id' 	=> $user->id,
	'post_id' 	=> $post->id,
	'value' 	=> CN_VOTE_UP
);

if ( CN_Vote::newVote( $newVote ) )
	echo 'Voted!';
else
	echo 'Failed voting!';
?>