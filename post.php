<?php

/*************************************************
			Post Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		Displays single post specified by GET
		parameter pid	
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

if( !empty( $_POST ) && !empty( $_POST['post_id'] ) && !empty( $_POST['user_id'] ) && isset( $_POST['body'] ) ) {
	if (!empty( $_POST['body'] )) {
		if ( CN_Comment::add( $_POST ) ) {
			$cn->enqueueMessage(
				'Successfully commented on post.',
				CN_MSG_SUCCESS,
				$_SESSION['sessionID']
			);
		} else {
			$cn->enqueueMessage(
				'Error commenting on post.',
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
		}
	} else {
		$cn->enqueueMessage(
			'Please provide a comment.',
			CN_MSG_ERROR,
			$_SESSION['sessionID']
		);
	}	
	
	// Redirect back to post that was commented on
	CN::redirect( CN_WEBROOTPAGE . 'post?pid=' . $_POST['post_id'] );
} 

if( !empty( $_GET ) && !empty( $_GET['pid'] ) ) {
	
	// Initialize new post with specified pid (GET param)
	$post = new CN_Post( $_GET['pid'] );
	$post->view();
	
	// Get all comments for current post
	$comments = $post->getComments();

	// Require header global
	require_once( CN_DIR_GLOBALS . 'header.php' );
	require_once( CN_DIR_GLOBALS . 'breadCrumbs.php' );
	?>	
				<div id="post-info">
					<div class="info">
						Author: <a href="<?php echo CN_WEBACCOUNT . '?user=' . $post->author->username; ?>"><?php echo $post->author->username; ?></a><br />
						Started: <?php echo date( CN_DATE_FORMAT, $post->date ); ?><br />
						Updated: <?php echo date( CN_DATE_FORMAT, $post->updated ); ?><br />
						Comments: <?php echo count( $post->getComments() ); ?><br />
						Views: <?php echo $post->views; ?><br />
					</div>
					<div class="main">
						<div class="title"><?php echo $post->title; ?></div>
						<div class="desc"><?php echo $post->details; ?></div>
					</div>
					<div class="clear"></div>
				</div>
				<div id="post">
					<?php require_once CN_DIR_AJAX . 'post.php'; ?>
				</div>
				<hr>
				<form id="new_comment" method="post" action="<?php echo CN_WEBROOTPAGE . 'post?pid=' . $_GET['pid']; ?>">
					<input type="hidden" id="post_id" name="post_id" value="<?php echo $post->id; ?>" />
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id; ?>" />
					<label for="body">Comment:</label>
					<br />
					<textarea id="body" name="body"></textarea>
					<br />
					<input type="submit" value="Comment" />
				</form>
				
<input type="hidden" id="page" name="page" value="post" />
<input type="hidden" id="page-title" name="page-title" value="<?php echo $post->title; ?>" />

	<?
	// Require footer global
	require_once( CN_DIR_GLOBALS . 'footer.php' );
}
?>