<?php
/*************************************************
			Topics AJAX Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		AJAX Page to build ONLY the topics content
		(displays all topics)
*************************************************/
if ( count( $topics ) > 0 ) { ?>
	<div id="topics">
	<?php foreach( $topics as $t ) { ?>
		<div class="topic" onclick="window.location='<?php echo CN_WEBROOTPAGE . 'topic?tid=' . $t->id; ?>'">
			<div class="info">
				Author: <a href="<?php echo CN_WEBACCOUNT . '?user=' . $t->author->username; ?>"><?php echo $t->author->username; ?></a><br />
				Started: <?php echo date( CN_DATE_FORMAT, $t->date ); ?><br />
				Updated: <?php echo date( CN_DATE_FORMAT, $t->updated ); ?><br />
				Posts: <?php echo count( $t->getPosts() ); ?><br />
				Views: <?php echo $t->views; ?><br />
			</div>
			<div class="main">
				<div class="title"><?php echo $t->title; ?></div>
				<div class="desc"><?php echo $t->details; ?></div>
			</div>
			<div class="clear"></div>
		</div>
	<?php } ?>
	</div>
<?php } else { echo '<p>No Topics</p>'; } ?>