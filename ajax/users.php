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
$regular = CN_User::getPermission( CN_PERM_USER );
$mods = CN_User::getPermission( CN_PERM_MOD );
$admins = CN_User::getPermission( CN_PERM_ADMIN );

$usergroups = array(
	'disabled' => array(
		'title' => 'Disabled Users',
		'empty' => 'No Disabled Users',
		'users' => $disabled
	),
	'regular' => array(
		'title' => 'Regular Users',
		'empty' => 'No Regular Users',
		'users' => $regular
	),
	'mod' => array(
		'title' => 'Moderators',
		'empty' => 'No Moderators',
		'users' => $mods
	),
	'admin' => array(
		'title' => 'Administrators',
		'empty' => 'No Administrators',
		'users' => $admins
	),
);

foreach ( $usergroups as $group => $info ) {
?>
	<h2><?php echo $info['title']; ?></h2>
	<div id="<?php echo $group; ?>-users">
	<?php if ( count( $info['users'] ) > 0 ) {
		foreach( $info['users'] as $user ) { ?>
			<div class="user">
				<?php echo $user->fullname; ?> | <a href="<?php echo CN_WEBACCOUNT . '?user=' . $user->username; ?>"><?php echo $user->username; ?></a>
			</div>
		<?php } 
	} else { echo '<p>' . $info['empty'] . '</p>'; } ?>
	</div>
<?php } ?>
	