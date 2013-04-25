<?php
/*************************************************
			Topic AJAX Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		AJAX Page to build ONLY the topic content
		specified by POST parameter tid
*************************************************/
if ( count( $posts ) > 0 ) { 
	foreach( $posts as $p ) { 
		$upvoteInfo = array(
			'user_id' 	=> $user->id,
			'post_id' 	=> $p->id,
			'value' 	=> CN_VOTE_UP
		);
		
		$downvoteInfo = array(
			'user_id' 	=> $user->id,
			'post_id' 	=> $p->id,
			'value' 	=> CN_VOTE_DOWN
		);
	?>
		<div class="post">
			<div class="info">
				Author: <a href="<?php echo CN_WEBACCOUNT . '?user=' . $p->author->username; ?>"><?php echo $p->author->username; ?></a><br />
				Started: <?php echo date( CN_DATE_FORMAT, $p->date ); ?><br />
				Updated: <?php echo date( CN_DATE_FORMAT, $p->updated ); ?><br />
				Comments: <?php echo count( $p->getComments() ); ?><br />
				Views: <?php echo $p->views; ?><br />
			</div>
			<div class="vote">
    			<img onclick="votePost(<?php echo $p->id . ', ' . CN_VOTE_UP; ?>)" src="<?php echo CN_WEBDIR_ICONS; ?>mana.png" />
				<br />
				<?php echo $p->getMana(); ?>
				<br />
				<img onclick="votePost(<?php echo $p->id . ', ' . CN_VOTE_DOWN; ?>)" src="<?php echo CN_WEBDIR_ICONS; ?>bana.png" />
    		</div>
			<div class="main" onclick="window.location='<?php echo CN_WEBROOTPAGE . 'post?pid=' . $p->id; ?>';">
				<div class="title"><?php echo $p->title; ?></div>
				<div class="desc"><?php echo $p->details; ?></div>
			</div>
			<div class="clear"></div>
		</div>
	<?php }
} else { echo '<p>No Posts</p>'; } ?>