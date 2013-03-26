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

$topics = CN_Topic::getAll();

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<h1>Topics</h1>
				<hr>
				<table id="topics">
					<thead>
						<tr>
							<td>Topic</td>
							<td>Stats</td>
							<td>Details</td>
						</tr>
					</thead>
				<?php foreach( $topics as $t ) { ?>
					<tr class="topic">
						<td class="title">
							<a href="<?php echo CN_WEBROOTPAGE . 'topic?tid=' . $t->id; ?>">
								<strong><?php echo $t->title; ?></strong>
							</a>
							<div class="smallfont">
								<?php echo $t->details; ?>
							</div>
						</td>
						<td class="stats">
							<div class="smallfont">
								Posts: <strong><?php echo count( $t->getPosts() ); ?></strong>
							</div>
							<div class="smallfont">
								Views: <strong><?php echo $t->views; ?></strong>
							</div>
						</td>
						<td class="details">
							<div class="smallfont">
								Created: <?php echo date( CN_DATE_FORMAT, $t->date ); ?>
							</div>
							<div class="smallfont">
								Updated: <?php echo date( CN_DATE_FORMAT, $t->updated ); ?>
							</div>
							<div class="smallfont">
								Author: <?php echo $t->author->username . ' (' . $t->author->firstname . ' ' . $t->author->lastname . ')'; ?>
							</div>
						</td>
					</tr>
				<?php } ?>
				</table>
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