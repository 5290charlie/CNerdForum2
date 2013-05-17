<?php

/*************************************************
			Post AJAX Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		AJAX Page to build ONLY the post content
		specified by POST parameter pid
*************************************************/
if ( count( $comments ) > 0 ) { 
	foreach( $comments as $c ) { ?>
		<div class="comment">
    		<div class="left">
        		<div class="vote">
        			<img onclick="voteComment(<?php echo $c->id . ', ' . CN_VOTE_UP; ?>)" src="<?php echo CN_WEBDIR_ICONS; ?>mana.png" />
				<br />
				<?php echo $c->getMana(); ?>
				<br />
				<img onclick="voteComment(<?php echo $c->id . ', ' . CN_VOTE_DOWN; ?>)" src="<?php echo CN_WEBDIR_ICONS; ?>bana.png" />
        		</div>
        		<hr>
        		<div class="userdata">
        			<a href="<?php echo CN_WEBACCOUNT . '?user=' . $c->author->username; ?>"><?php echo $c->author->username; ?></a><br />
        			[<img width="10" src="<?php echo CN_WEBDIR_ICONS; ?>mana.png" /> <?php echo $c->author->getMana(); ?>  <span class="rank"><?php echo $c->author->getRank(); ?></span>] 
        			<img width="75" src="<?php echo CN_WEBDIR_IMAGES; ?>avatar.gif" /><br />
        			<?php echo $c->author->fullname; ?>
        		</div>
			</div>
    		<div class="main">
    			<div class="date">
    				<?php echo date( CN_DATE_FORMAT, $c->date ); ?>
    			</div>
    			<div class="body">
    				<p><?php echo $c->body; ?></p>
    			</div>
    		</div>
    		<div class="clear"></div>
    	</div>
		
	<?php }
} else { echo '<p>No Comments</p>'; } ?>