<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if( !empty( $_POST ) && !empty( $_POST['post_id'] ) && !empty( $_POST['user_id'] ) && !empty( $_POST['body'] ) ) {
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
	
	CN::redirect( CN_WEBROOTPAGE . 'post?pid=' . $_POST['post_id'] );
} 

if( !empty( $_GET ) && !empty( $_GET['pid'] ) ) {
	$post = new CN_Post( $_GET['pid'] );
	$post->view();
	
	$comments = $post->getComments();

	// Require header global
	require_once( CN_DIR_GLOBALS . 'header.php' );
	?>
				<h1>Post: <?php echo $post->title; ?></h1>
				<hr>
				<h2>Comments:</h2>
				<?php if ( count( $comments ) > 0 ) { ?>
					<ul>
					<?php foreach( $comments as $c ) { ?>
						<li>
							<strong>Body:</strong> <?php echo $c->body; ?><br />
							<strong>Date:</strong> <?php echo date( CN_DATE_FORMAT, $c->date ); ?><br />
							<strong>Author:</strong> <?php echo $c->author->username . ' (' . $c->author->firstname . ' ' . $c->author->lastname . ')'; ?>
						</li>
					<?php } ?>
					</ul>
				<?php } else { echo 'No Comments'; } ?>
				<hr>
				<form id="new_comment" method="post" action="<?php echo CN_WEBROOTPAGE . 'post'; ?>">
					<input type="hidden" id="post_id" name="post_id" value="<?php echo $post->id; ?>" />
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id; ?>" />
					<label for="body">Comment:</label>
					<textarea id="body" name="body"></textarea>
					<br />
					<input type="submit" value="Comment" />
				</form>
	<?
	// Require footer global
	require_once( CN_DIR_GLOBALS . 'footer.php' );
}
?>