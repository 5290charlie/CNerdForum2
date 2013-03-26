<?php
// Prevent direct access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

$str = '<a href="/">Home</a> | ';
$topics_link = '<a href="' . CN_WEBROOTPAGE . 'topics">Topics</a> | ';

if( strpos( $_SERVER['REQUEST_URI'], 'post' ) !== false ) {
	$topic_link = '<a href="' . CN_WEBROOTPAGE . 'topic?tid=' . $post->topic->id . '">' . $post->topic->title . '</a> | ';
	$str = $str . $topics_link . $topic_link . $post->title;
} elseif( strpos( $_SERVER['REQUEST_URI'], 'topics' ) !== false ) {
	$str = $str . 'Topics';
} elseif( strpos( $_SERVER['REQUEST_URI'], 'topic' ) !== false ) {
	$str = $str . $topics_link . $topic->title;
}

echo $str;
?>