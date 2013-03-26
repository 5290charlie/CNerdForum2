<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

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
	
	CN::redirect( CN_WEBROOT_PAGE . 'topics' );
}

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<h1>Topics</h1>
				<hr>
				<?php
				$topics = CN_Topic::getAll();
				print_r( $topics );
				?>
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