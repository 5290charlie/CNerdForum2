<?php

/*************************************************
			Account Page
**************************************************
	Author: Charlie McClung
	Updated: 4/2/2013
		Display current users account info
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

// Require header global
require_once CN_DIR_GLOBALS . 'header.php';
?>

<div id="account">
	<p><?php echo $user->username; ?>
		[<img src="<?php echo CN_WEBDIR_ICONS; ?>upvote.png" width="10" /> 
		<?php echo $user->getMana(); ?> 
		<span class="rank"><?php echo $user->getRank(); ?></span>]
	</p>
	<p><?php echo $user->fullname; ?></p>
	<p><?php echo $user->email; ?></p>
	<p><?php echo $user->permission; ?></p>
	<p>TROPHIES:</p>
	<?php
	$trophies = CN_Trophy::getTrophies( $user->getMana() );
	foreach ( $trophies as $trophy ) {
		echo '<img src="' . $trophy->icon . '" />';	
	}
	?>

</div>

<?php
// Require footer global
require_once CN_DIR_GLOBALS . 'footer.php';
?>