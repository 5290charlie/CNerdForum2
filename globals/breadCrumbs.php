<?php

/*************************************************
			Global Breadcrumbs
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		Builds page tracking links at the top of
		content div
*************************************************/

// Prevent direct access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

// Begin breadcrumb links as string
$str = ''; // '<a href="/">Home</a>';
$topics_link = '<a href="' . CN_WEBROOTPAGE . 'topics">Topics</a> -> ';

// Breadcrumbs string for post page
if( strpos( $_SERVER['REQUEST_URI'], 'post' ) !== false ) {
	$topic_link = '<a href="' . CN_WEBROOTPAGE . 'topic?tid=' . $post->topic->id . '">' . $post->topic->title . '</a> -> ';
	$str = $str . $topics_link . $topic_link . $post->title;

// Breadcrumbs string for topics page
} elseif( strpos( $_SERVER['REQUEST_URI'], 'topics' ) !== false ) {
	$str = $str . 'Topics';

// Breadcrumbs string for single topic page
} elseif( strpos( $_SERVER['REQUEST_URI'], 'topic' ) !== false ) {
	$str = $str . $topics_link . $topic->title;

// Breadcrumbs string for account page
} elseif( strpos( $_SERVER['REQUEST_URI'], 'account' ) !== false ) {
	$str = $str . 'Account';
}
?>
<div id="breadcrumbs">
	<?php echo $str; ?>
</div>
