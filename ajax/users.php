<?php
/*************************************************
			Users AJAX Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		AJAX Page to build ONLY the users content
		(displays all users and information)
*************************************************/

// Initialize users object with all users
$disabled = CN_User::getPermission( CN_PERM_DISABLED );
$users = CN_User::getPermission( CN_PERM_USER );
$mods = CN_User::getPermission( CN_PERM_MOD );
$admins = CN_User::getPermission( CN_PERM_ADMIN );
?>
	<h2>Disabled Users</h2>
	<div id="disabled-users">
	<?php if ( count( $disabled ) > 0 ) {
		foreach( $disabled as $user ) { ?>
			<div class="user" onclick="window.location='<?php echo CN_WEBACCOUNT . '?user=' . $user->username; ?>'">
				<?php echo $user->fullname; ?>
			</div>
		<?php } 
	} else { echo '<p>No Disabled Users</p>'; } ?>
	</div>
	<h2>Regular Users</h2>
	<div id="regular-users">
	<?php if ( count( $users ) > 0 ) {
		foreach( $users as $user ) { ?>
			<div class="user" onclick="window.location='<?php echo CN_WEBACCOUNT . '?user=' . $user->username; ?>'">
				<?php echo $user->fullname; ?>
			</div>
		<?php } 
	} else { echo '<p>No Regular Users</p>'; } ?>
	</div>
	<h2>Moderators</h2>
	<div id="mod-users">
	<?php if ( count( $mods ) > 0 ) {
		foreach( $$mods as $user ) { ?>
			<div class="user" onclick="window.location='<?php echo CN_WEBACCOUNT . '?user=' . $user->username; ?>'">
				<?php echo $user->fullname; ?>
			</div>
		<?php } 
	} else { echo '<p>No Moderators</p>'; } ?>
	</div>
	<h2>Administrators</h2>
	<div id="admin-users">
	<?php if ( count( $admins ) > 0 ) {
		foreach( $admins as $user ) { ?>
			<div class="user" onclick="window.location='<?php echo CN_WEBACCOUNT . '?user=' . $user->username; ?>'">
				<?php echo $user->fullname; ?>
			</div>
		<?php } 
	} else { echo '<p>No Administrators</p>'; } ?>
	</div>