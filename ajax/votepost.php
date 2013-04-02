<?php

/*************************************************
			Voting Post AJAX Page
**************************************************
	Author: Charlie McClung
	Updated: 4/2/2013
		Create new post vote and reload data
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

if ( !empty( $_POST ) && !empty( $_POST['post_id'] ) && !empty( $_POST['value'] ) ) {	
	$post = new CN_Post( $_POST['post_id'] );
	
	$newVote = array(
		'user_id' 	=> $user->id,
		'post_id' 	=> $post->id,
		'value' 	=> $_POST['value']
	);
	
	if ( CN_Vote::votePost( $newVote ) ) {
	
		$posts = $post->topic->getPosts();
		
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
	} else { echo 'Error voting!'; }
}?>