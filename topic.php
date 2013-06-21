<?php

/*************************************************
			Topic Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		Displays single topic specified by GET
		parameter tid
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if( !empty( $_POST ) && !empty( $_POST['topic_id'] ) && !empty( $_POST['user_id'] ) && isset( $_POST['title'] ) && isset( $_POST['details'] ) ) {
	$_POST['title'] = stripslashes( trim ( $_POST['title'] ) );
	$_POST['details'] = stripslashes( trim ( $_POST['details'] ) );
	
	$_SESSION['post_form_title'] = $_POST['title'];
	$_SESSION['post_form_details'] = $_POST['details'];

	error_log(print_r($_POST, true));

	if (!empty( $_POST['title'] ) && !empty( $_POST['details'] )) {
		if ( CN_Post::add( $_POST ) ) {
			$cn->enqueueMessage(
				'Successfully created post: ' . $_POST['title'],
				CN_MSG_SUCCESS,
				$_SESSION['sessionID']
			);
			unset($_SESSION['post_form_title']);
			unset($_SESSION['post_form_details']);
		} else {
			$cn->enqueueMessage(
				'Error creating post: ' . $_POST['title'],
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
		}
	} else {
		if (empty( $_POST['title'] )) {
			$cn->enqueueMessage(
				'Please provide a title for your post.',
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
		}
		
		if (empty( $_POST['details'] )) {
			$cn->enqueueMessage(
				'Please provide details for your post.',
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
		}
	}
	
	CN::redirect( CN_WEBROOTPAGE . 'topic?tid=' . $_POST['topic_id'] );
} 

if( !empty( $_GET ) && !empty( $_GET['tid'] ) ) {
	$topic = new CN_Topic( $_GET['tid'] );
	$topic->view();

	$posts = $topic->getPosts();
	
	// Require header global
	require_once( CN_DIR_GLOBALS . 'header.php' );
	require_once( CN_DIR_GLOBALS . 'breadCrumbs.php' );
	?>
			
				<div id="topic-info">
					<div class="info">
						Author: <a href="<?php echo CN_WEBACCOUNT . '?user=' . $topic->author->username; ?>"><?php echo $topic->author->username; ?></a><br />
						Started: <?php echo date( CN_DATE_FORMAT, $topic->date ); ?><br />
						Updated: <?php echo date( CN_DATE_FORMAT, $topic->updated ); ?><br />
						Posts: <?php echo count( $topic->getPosts() ); ?><br />
						Views: <?php echo $topic->views; ?><br />
					</div>
					<div class="main">
						<div class="title"><?php echo $topic->title; ?></div>
						<div class="desc"><?php echo $topic->details; ?></div>
					</div>
					<div class="clear"></div>
				</div>
				<div id="topic">
					<?php require_once CN_DIR_AJAX . 'topic.php'; ?>
				</div>
				<hr>
				<form id="new_post" method="post" action="<?php echo CN_WEBROOTPAGE . 'topic?tid=' . $_GET['tid']; ?>">
					<input type="hidden" id="topic_id" name="topic_id" value="<?php echo $topic->id; ?>" />
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id; ?>" />
					<label for="title">Title:</label>
					<input type="text" id="title" name="title" value="<?php echo isset( $_SESSION['post_form_title'] ) ? $_SESSION['post_form_title'] : '';?>" />
					<br />
					<label for="details">Details:</label>
					<br />
					<textarea id="details" name="details"><?php echo isset( $_SESSION['post_form_details'] ) ? $_SESSION['post_form_details'] : ''; ?></textarea>
					<br />
					<input type="submit" value="Add Post" />
				</form>
				
<input type="hidden" id="page" name="page" value="topic" />
<input type="hidden" id="page-title" name="page-title" value="<?php echo $topic->title; ?>" />


	<?
	// Require footer global
	require_once( CN_DIR_GLOBALS . 'footer.php' );
}
?>