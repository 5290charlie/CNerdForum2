<?php

/*************************************************
			Topics Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		Displays All Topics
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

if ( !empty( $_POST ) && !empty( $_POST['user_id'] ) && isset( $_POST['title'] ) && isset( $_POST['details'] ) ) {
	$_POST['title'] = stripslashes( trim ( $_POST['title'] ) );
	$_POST['details'] = stripslashes( trim ( $_POST['details'] ) );
	
	$_SESSION['topic_form_title'] = $_POST['title'];
	$_SESSION['topic_form_details'] = $_POST['details'];

	if (!empty( $_POST['title'] ) && !empty( $_POST['details'] )) {
		if ( CN_Topic::add( $_POST ) ) {
			$cn->enqueueMessage(
				'Successfully created topic: ' . $_POST['title'],
				CN_MSG_SUCCESS,
				$_SESSION['sessionID']
			);
			unset($_SESSION['topic_form_title']);
			unset($_SESSION['topic_form_details']);
		} else {
			$cn->enqueueMessage(
				'Error creating topic: ' . $_POST['title'],
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
		}
	} else {
		if (empty( $_POST['title'] )) {
			$cn->enqueueMessage(
				'Please provide a title for your topic.',
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
		}
		
		if (empty( $_POST['details'] )) {
			$cn->enqueueMessage(
				'Please provide details for your topic.',
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
		}
	}
	
	// Redirect back to topics page after creating topic
	CN::redirect( CN_WEBROOTPAGE . 'topics' );
}

// Initialize topics object with all topics
$topics = CN_Topic::getAll();

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
require_once( CN_DIR_GLOBALS . 'breadCrumbs.php' );
?>
				
				<?php require_once CN_DIR_AJAX . 'topics.php'; ?>
				<hr>
				<form id="new_topic" method="post" action="<?php echo CN_WEBROOTPAGE . 'topics'; ?>">
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id; ?>" />
					<label for="title">Title:</label>
					<input type="text" id="title" name="title" value="<?php echo isset( $_SESSION['topic_form_title'] ) ? $_SESSION['topic_form_title'] : '';?>" />
					<br />
					<label for="details">Details:</label>
					<br />
					<textarea id="details" name="details"><?php echo isset( $_SESSION['topic_form_details'] ) ? $_SESSION['topic_form_details'] : '';?></textarea>
					<br />
					<input type="submit" value="Add Topic" />
				</form>

<input type="hidden" id="page" name="page" value="topics" />
<input type="hidden" id="page-title" name="page-title" value="Topics" />

<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>