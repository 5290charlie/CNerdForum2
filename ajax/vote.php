<?php

/*************************************************
			Voting AJAX Page
**************************************************
	Author: Charlie McClung
	Updated: 4/2/2013
		CNerdForum Homepage
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

if ( !empty( $_POST ) && !empty( $_POST['object_id'] ) && !empty( $_POST['object_type'] ) && !empty( $_POST['value'] ) ) {
	$type = $_POST['object_type'];
	
	if ( $type == 'post' )
		$object = new CN_Post( $_POST['object_id'] );
	elseif ( $type == 'comment' )
		$object = new CN_Comment( $_POST['object_id'] );
	else
		throw new Exception( 'Invalid voting object type!' );
	
	$newVote = array(
		'user' 		=> $user,
		'object' 	=> $object,
		'value' 	=> $_POST['value']
	);
	
	// Add the new vote - DOESN'T WORK!!!
	if ( CN_Vote::add( $newVote ) ) {
	
		// Reload comments section for comment voting
		if ( $type == 'comment' ) {
		
			$comments = $object->post->getComments();
			
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
		} 
		
		
		if ( $type == 'post' ) {
			$posts = $object->topic->getPosts();
		
			if ( count( $posts ) > 0 ) { ?>
						<table id="posts">
						<?php foreach( $posts as $p ) { ?>
							<tr class="post">
								<td class="vote">
									<img onclick="votePost(<?php echo $p->id . ', ' . CN_VOTE_UP; ?>)" src="<?php echo CN_WEBDIR_ICONS; ?>upvote.png" />
									<br />
									<?php echo $p->getMana(); ?>
									<br />
									<img onclick="votePost(<?php echo $p->id . ', ' . CN_VOTE_DOWN; ?>)" src="<?php echo CN_WEBDIR_ICONS; ?>downvote.png" />
								</td>
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
										Comments: <?php echo count( $p->getComments() ); ?>
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
		<?php } else { echo 'No Posts'; }
		}
	} else { echo 'Error voting!'; }
	
	unset($object);
} ?>