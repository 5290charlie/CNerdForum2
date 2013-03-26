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
	
	CN::redirect( CN_WEBROOTPAGE . 'topics' );
}

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<h1>Topics</h1>
				<hr>
				<ul>
				<?php
				$topics = CN_Topic::getAll();
				
				foreach( $topics as $t ) { ?>
					<li>
						<strong>Title:</strong> <?php echo $t->title; ?> (<a href="<?php echo CN_WEBROOTPAGE . 'touch?tid=' . $t->id; ?>">touch</a>)<br />
						<strong>Details:</strong> <?php echo $t->details; ?><br />
						<strong>Date:</strong> <?php echo date( CN_DATE_FORMAT, $t->date ); ?><br />
						<strong>Updated:</strong> <?php echo date( CN_DATE_FORMAT, $t->updated ); ?><br />
						<strong>Author:</strong> <?php echo $t->author->username . ' (' . $t->author->firstname . ' ' . $t->author->lastname . ')'; ?>
					</li>
				<?php }
				?>
				</ul>
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