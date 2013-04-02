<?php

/*************************************************
			Comment Voting AJAX Page
**************************************************
	Author: Charlie McClung
	Updated: 4/2/2013
		Create new comment vote and reload data
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

if ( !empty( $_POST ) && !empty( $_POST['comment_id'] ) && !empty( $_POST['value'] ) ) {
	$comment = new CN_Comment( $_POST['comment_id'] );
	
	$newVote = array(
		'user_id' 		=> $user->id,
		'comment_id' 	=> $_POST['comment_id'],
		'value' 		=> $_POST['value']
	);
	
	if (CN_Vote::voteComment( $newVote )) {
	
		$comments = $comment->post->getComments();
		
		if ( count( $comments ) > 0 ) { ?>
						<table id="comments">
						<?php foreach( $comments as $c ) { ?>
							<tr class="comment">
								<td class="vote">
									<img onclick="voteComment(<?php echo $c->id . ', ' . CN_VOTE_UP; ?>)" src="<?php echo CN_WEBDIR_ICONS; ?>upvote.png" />
									<br />
									<?php echo $c->getMana(); ?>
									<br />
									<img onclick="voteComment(<?php echo $c->id . ', ' . CN_VOTE_DOWN; ?>)" src="<?php echo CN_WEBDIR_ICONS; ?>downvote.png" />
								</td>
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
		<?php } else { echo 'No Comments'; } 
	} else { echo 'Error voting!'; }
} ?>