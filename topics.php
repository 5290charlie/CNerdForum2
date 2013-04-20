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

if ( !empty( $_POST ) && !empty( $_POST['user_id'] ) && !empty( $_POST['title'] ) && !empty( $_POST['details'] ) ) {
	if ( CN_Topic::add( $_POST ) ) {
		$cn->enqueueMessage(
			'Successfully created topic: ' . $_POST['title'],
			CN_MSG_SUCCESS,
			$_SESSION['sessionID']
		);
	} else {
		$cn->enqueueMessage(
			'Error creating topic: ' . $_POST['title'],
			CN_MSG_ERROR,
			$_SESSION['sessionID']
		);
	}
	
	// Redirect back to topics page after creating topic
	CN::redirect( CN_WEBROOTPAGE . 'topics' );
}

// Initialize topics object with all topics
$topics = CN_Topic::getAll();

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<?php if ( count( $topics ) > 0 ) { ?>
					<div id="topics">
					<?php foreach( $topics as $t ) { ?>
						<div class="topic" onclick="window.location='<?php echo CN_WEBROOTPAGE . 'topic?tid=' . $t->id; ?>'">
							<div class="info">
								Started: <?php echo date( CN_DATE_FORMAT, $t->date ); ?> | By: <?php echo $t->author->username; ?><br />
								Updated: <?php echo date( CN_DATE_FORMAT, $t->updated ); ?><br />
								Posts: <?php echo count( $t->getPosts() ); ?><br />
								Views: <?php echo $t->views; ?><br />
							</div>
							<div class="main">
								<div class="title"><?php echo $t->title; ?></div>
								<div class="desc"><?php echo $t->details; ?></div>
							</div>
							<div class="clear"></div>
						</div>
					<?php } ?>
					</div>
				<?php } else { echo 'No Topics'; } ?>
				<hr>
				<form id="new_topic" method="post" action="<?php echo CN_WEBROOTPAGE . 'topics'; ?>">
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id; ?>" />
					<label for="title">Title:</label>
					<input type="text" id="title" name="title" />
					<br />
					<label for="details">Details:</label>
					<textarea id="details" name="details"></textarea>
					<br />
					<input type="submit" value="Add Topic" />
				</form>

<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>