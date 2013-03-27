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
				<?php if ( count( $comments ) > 0 ) { ?>
					<table id="comments">
					<?php foreach( $comments as $c ) { ?>
						<tr class="comment">
							<td class="user">
								<div class="username">
									<?php echo $c->author->username; ?>
								</div>
							</td>
							<td class="body">
								<div class="date">
									<?php echo date( CN_DATE_FORMAT, $c->date ); ?>
								</div>
								<p>
									<?php echo $c->body; ?>
								</p>
							</td>
						</tr>
					<?php } ?>
					</table>
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