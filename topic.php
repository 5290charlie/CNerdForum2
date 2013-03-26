<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if( !empty( $_POST ) && !empty( $_POST['topic_id'] ) && !empty( $_POST['user_id'] ) && !empty( $_POST['title'] ) && !empty( $_POST['details'] ) ) {
	if ( CN_Post::add( $_POST ) ) {
		$cn->enqueueMessage(
			'Successfully created post: ' . $_POST['title'],
			CN_MSG_SUCCESS,
			$_SESSION['sessionID']
		);
	} else {
		$cn->enqueueMessage(
			'Error creating post: ' . $_POST['title'],
			CN_MSG_ERROR,
			$_SESSION['sessionID']
		);
	}
	
	CN::redirect( CN_WEBROOTPAGE . 'topic?tid=' . $_POST['topic_id'] );
} 

if( !empty( $_GET ) && !empty( $_GET['tid'] ) ) {
	$topic = new CN_Topic( $_GET['tid'] );
	$topic->view();

	$posts = $topic->getPosts();
	
	// Require header global
	require_once( CN_DIR_GLOBALS . 'header.php' );
	?>
				<?php if ( count( $posts ) > 0 ) { ?>
					<table id="posts">
						<thead>
							<tr>
								<td>Post Title and Details</td>
								<td>Stats</td>
								<td>Info</td>
							</tr>
						</thead>
					<?php foreach( $posts as $p ) { ?>
						<tr class="post">
							<td class="title">
								<a href="<?php echo CN_WEBROOTPAGE . 'post?pid=' . $p->id; ?>">
									<strong><?php echo $p->title; ?></strong>
								</a>
								<div class="smallfont">
									<?php echo $p->details; ?>
								</div>
							</td>
							<td class="stats">
								<div class="smallfont">
									Posts: <?php echo count( $p->getComments() ); ?>
								</div>
								<div class="smallfont">
									Views: <?php echo $p->views; ?>
								</div>
							</td>
							<td class="details">
								<div class="smallfont">
									Created: <?php echo date( CN_DATE_FORMAT, $p->date ); ?>
								</div>
								<div class="smallfont">
									Updated: <?php echo date( CN_DATE_FORMAT, $p->updated ); ?>
								</div>
								<div class="smallfont">
									Author: <?php echo $p->author->username; ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					</table>
				<?php } else { echo 'No Posts'; } ?>
				<hr>
				<form id="new_post" method="post" action="<?php echo CN_WEBROOTPAGE . 'topic'; ?>">
					<input type="hidden" id="topic_id" name="topic_id" value="<?php echo $topic->id; ?>" />
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id; ?>" />
					<label for="title">Title:</label>
					<input type="text" id="title" name="title" />
					<br />
					<label for="details">Details:</label>
					<textarea id="details" name="details"></textarea>
					<br />
					<input type="submit" value="Add Post" />
				</form>
	<?
	// Require footer global
	require_once( CN_DIR_GLOBALS . 'footer.php' );
}
?>