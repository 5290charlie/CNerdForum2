<?php
/*************************************************
			Users AJAX Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		AJAX Page to build ONLY the users content
		(displays all users and information)
*************************************************/

if ( count( $users ) > 0 ) { ?>
	<div id="users">
	<?php foreach( $users as $user ) { ?>
		<div class="user" onclick="window.location='<?php echo CN_WEBACCOUNT . '?user=' . $user->username; ?>'">
			<?php var_dump($user); ?>
		</div>
	<?php } ?>
	</div>
<?php } else { echo '<p>No Topics</p>'; } ?>